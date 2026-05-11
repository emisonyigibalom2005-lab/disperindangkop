<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\User;
use App\Models\Anggota;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        $petugasId = auth()->id();
        
        // Ambil Admin dan Pimpinan
        $adminPimpinan = User::whereIn('role', ['admin', 'pimpinan'])
            ->where('is_active', 1)
            ->get()
            ->map(function($user) use ($petugasId) {
                $lastMessage = Chat::between($petugasId, $user->id)
                    ->latest()
                    ->first();
                
                $unreadCount = Chat::where('pengirim_id', $user->id)
                    ->where('penerima_id', $petugasId)
                    ->unread()
                    ->count();
                
                $user->last_message = $lastMessage;
                $user->unread_count = $unreadCount;
                $user->has_conversation = $lastMessage ? true : false;
                $user->anggota_info = null; // Admin/Pimpinan tidak punya info anggota
                
                return $user;
            })
            ->sortByDesc(function($user) {
                if ($user->last_message) {
                    return $user->last_message->created_at->timestamp;
                }
                return 0;
            });
        
        // Ambil semua user yang pernah chat dengan petugas atau semua anggota
        $chatUserIds = Chat::where('pengirim_id', $petugasId)
            ->orWhere('penerima_id', $petugasId)
            ->get()
            ->pluck('pengirim_id', 'penerima_id')
            ->flatten()
            ->unique()
            ->filter(function($userId) use ($petugasId) {
                return $userId != $petugasId;
            });
        
        // Ambil semua anggota aktif
        $anggotaUsers = Anggota::where('status', 'Aktif')
            ->with('user')
            ->get()
            ->pluck('user.id')
            ->filter();
        
        // Gabungkan user yang pernah chat dan semua anggota (exclude admin dan pimpinan)
        $allUserIds = $chatUserIds->merge($anggotaUsers)->unique();
        
        // Ambil detail user dan pesan terakhir (hanya anggota)
        $conversations = User::whereIn('id', $allUserIds)
            ->where('is_active', 1)
            ->whereNotIn('role', ['admin', 'pimpinan']) // Exclude admin dan pimpinan dari list anggota
            ->get()
            ->map(function($user) use ($petugasId) {
                $lastMessage = Chat::between($petugasId, $user->id)
                    ->latest()
                    ->first();
                
                $unreadCount = Chat::where('pengirim_id', $user->id)
                    ->where('penerima_id', $petugasId)
                    ->unread()
                    ->count();
                
                $user->last_message = $lastMessage;
                $user->unread_count = $unreadCount;
                $user->has_conversation = $lastMessage ? true : false;
                
                // Tambahkan info anggota jika ada
                $anggota = Anggota::where('user_id', $user->id)->first();
                $user->anggota_info = $anggota;
                
                return $user;
            })
            ->sortByDesc(function($user) {
                // Urutkan: yang punya pesan terakhir di atas
                if ($user->last_message) {
                    return $user->last_message->created_at->timestamp;
                }
                return 0;
            });
        
        // Total pesan belum dibaca
        $totalUnread = Chat::where('penerima_id', $petugasId)
            ->unread()
            ->count();
        
        return view('petugas.chat.index', compact('conversations', 'totalUnread', 'adminPimpinan'));
    }

    public function show($userId)
    {
        $petugasId = auth()->id();
        $user = User::findOrFail($userId);
        
        // Ambil info anggota jika ada
        $anggota = Anggota::where('user_id', $userId)->first();
        $user->anggota_info = $anggota;
        
        // Ambil semua pesan
        $messages = Chat::between($petugasId, $userId)
            ->with(['pengirim', 'penerima'])
            ->orderBy('created_at', 'asc')
            ->get();
        
        // Tandai sebagai sudah dibaca
        Chat::where('pengirim_id', $userId)
            ->where('penerima_id', $petugasId)
            ->where('is_read', 0)
            ->update([
                'is_read' => 1,
                'read_at' => now()
            ]);
        
        return response()->json([
            'success' => true,
            'user' => $user,
            'messages' => $messages
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'penerima_id' => 'required|exists:users,id',
            'pesan' => 'required|string',
            'file' => 'nullable|file|max:10240'
        ]);
        
        $data = [
            'pengirim_id' => auth()->id(),
            'penerima_id' => $request->penerima_id,
            'pesan' => $request->pesan
        ];
        
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            $filePath = $file->store('chat-files', 'public');
            
            $data['file'] = $filePath;
            $data['original_filename'] = $originalName;
        }
        
        $chat = Chat::create($data);
        
        return response()->json([
            'success' => true,
            'message' => 'Pesan berhasil dikirim',
            'data' => $chat->load(['pengirim', 'penerima'])
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'pesan' => 'required|string'
        ]);
        
        $chat = Chat::findOrFail($id);
        
        if ($chat->pengirim_id != auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses untuk mengedit pesan ini'
            ], 403);
        }
        
        $chat->update([
            'pesan' => $request->pesan
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Pesan berhasil diupdate',
            'data' => $chat
        ]);
    }

    public function destroy($id)
    {
        $chat = Chat::findOrFail($id);
        
        if ($chat->pengirim_id != auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses untuk menghapus pesan ini'
            ], 403);
        }
        
        if ($chat->file) {
            \Storage::disk('public')->delete($chat->file);
        }
        
        $chat->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Pesan berhasil dihapus'
        ]);
    }
}

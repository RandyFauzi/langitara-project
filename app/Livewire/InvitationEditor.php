<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Invitation;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\WithFileUploads;
use App\Models\Template;
use App\Models\Song;
use App\Models\Guest;

#[Title('Editor Undangan')]
class InvitationEditor extends Component
{
    use AuthorizesRequests;
    use WithFileUploads;

    public $invitation;
    public $activeSection = 'mempelai';

    // Supporting Data
    public $templates;
    public $songs;
    public $currentSong;
    public $guests;
    public $stats;
    public $recentRsvps;
    public $wishes;

    // Temporary Uploads
    public $tempCoverImage;
    public $tempGroomPhoto;
    public $tempBridePhoto;
    public $tempGalleryPhotos = []; // Multi upload

    protected function rules()
    {
        return [
            'invitation.title' => 'nullable|string',
            'invitation.groom_name' => 'nullable|string',
            'invitation.groom_nickname' => 'nullable|string',
            'invitation.groom_father' => 'nullable|string',
            'invitation.groom_mother' => 'nullable|string',
            'invitation.bride_name' => 'nullable|string',
            'invitation.bride_nickname' => 'nullable|string',
            'invitation.bride_father' => 'nullable|string',
            'invitation.bride_mother' => 'nullable|string',
            'invitation.akad_date' => 'nullable|date',
            'invitation.akad_location' => 'nullable|string',
            'invitation.akad_address' => 'nullable|string',
            'invitation.akad_map_link' => 'nullable|string',
            'invitation.resepsi_date' => 'nullable|date',
            'invitation.resepsi_location' => 'nullable|string',
            'invitation.resepsi_address' => 'nullable|string',
            'invitation.resepsi_map_link' => 'nullable|string',
            'invitation.quote_text' => 'nullable|string',
            'invitation.quote_author' => 'nullable|string',
            'invitation.gallery_photos' => 'nullable|array',
            'invitation.love_stories' => 'nullable|array',
            'invitation.bank_accounts' => 'nullable|array',
            'invitation.music_path' => 'nullable|string',
            'invitation.template_id' => 'required|exists:templates,id',
        ];
    }

    public function mount($slug)
    {
        $this->invitation = Invitation::where('slug', $slug)
            ->with(['template'])
            ->firstOrFail();

        // Authorization
        if (Auth::id() !== $this->invitation->user_id && Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        // Initialize Defaults
        if (is_null($this->invitation->active_sections)) {
            $this->invitation->active_sections = ['cover', 'couple', 'quote', 'events', 'gallery', 'wishes', 'gift'];
        }
        if (is_null($this->invitation->gallery_photos))
            $this->invitation->gallery_photos = [];
        if (is_null($this->invitation->love_stories))
            $this->invitation->love_stories = [];
        if (is_null($this->invitation->bank_accounts))
            $this->invitation->bank_accounts = [];

        // Load Related Data
        $this->loadRelatedData();
    }

    public function loadRelatedData()
    {
        $this->templates = Template::where('status', 'active')->get();
        $this->songs = Song::where('status', 'active')->get();
        $this->guests = $this->invitation->guests()->orderBy('created_at', 'desc')->get();

        $totalGuests = $this->invitation->guests()->count();
        $rsvps = $this->invitation->rsvps()->orderBy('created_at', 'desc')->get();

        $this->stats = [
            'total_guests' => $totalGuests,
            'total_responses' => $rsvps->count(),
            'hadir' => $rsvps->where('status', 'hadir')->count(),
            'tidak_hadir' => $rsvps->where('status', 'tidak_hadir')->count(),
            'ragu' => $rsvps->where('status', 'ragu')->count(),
        ];

        $this->recentRsvps = $rsvps->take(10);
        $this->wishes = $this->invitation->rsvps()
            ->whereNotNull('message')
            ->where('message', '!=', '')
            ->orderBy('created_at', 'desc')
            ->get();

        $this->currentSong = $this->invitation->music_path
            ? Song::where('file_path', $this->invitation->music_path)->first()
            : null;
    }

    // Auto-save when updating model properties
    public function updated($property, $value)
    {
        if (str_starts_with($property, 'invitation.')) {
            $this->invitation->save();
        }
    }

    public function changeTemplate($templateId)
    {
        $this->invitation->template_id = $templateId;
        $this->invitation->save();
        $this->dispatch('notify', ['message' => 'Tema berhasil diganti!', 'type' => 'success']);
    }

    public function selectSong($url)
    {
        $this->invitation->music_path = $url;
        $this->invitation->save();
        $this->currentSong = Song::where('file_path', $url)->first();
    }

    public function publishInvitation()
    {
        // Simple Validation: Ensure Cover Title & Couple Names are mapped
        if (empty($this->invitation->title) || empty($this->invitation->groom_name) || empty($this->invitation->bride_name)) {
            $this->dispatch('notify', ['message' => 'Mohon lengkapi judul dan nama mempelai sebelum publish.', 'type' => 'error']);
            return;
        }

        $this->invitation->status = 'published';
        $this->invitation->save();

        $this->dispatch('notify', ['message' => 'Undangan berhasil di-publish!', 'type' => 'success']);
    }

    public function unpublishInvitation()
    {
        $this->invitation->status = 'draft';
        $this->invitation->save();

        $this->dispatch('notify', ['message' => 'Undangan dikembalikan ke draft.', 'type' => 'info']);
    }

    // --- Media Management ---

    // Note: Implementing proper Livewire file uploads for compatibility.
    // The previous JS implementation used a direct endpoint. We can support both,
    // but ideally we migrate to Livewire uploads for consistency.

    // For now, to keep strict UI focus, we'll assume the JS bridge might still be used for single images
    // OR we implement the methods to handle the temp files if we switch inputs to wire:model.

    public function render()
    {
        return view('livewire.invitation-editor')
            ->layout('layouts.editor');
    }
}

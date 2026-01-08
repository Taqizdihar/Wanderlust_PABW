@extends('layouts.ptw_master')

@section('content')

<div class="properties-container"> <div class="ticket-page-header">
        
    <div style="position: relative; padding-top: 20px;">
        <p class="subtitle">Manage tickets in</p>
        <h2 class="property-title">{{ $property->nama_wisata }}</h2>
        <a href="{{ route('properties.ptw') }}" class="btn-back" style="top: 20px;">
            &lt; Go Back
        </a>
    </div>
    
    <div class="action-bar" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        
        <a href="{{ route('tickets.ptw.create', $property->id_wisata) }}" class="btn-add-new" style="margin: 0;">
            + Add New Ticket
        </a>

        <form action="{{ route('properties.ptw.tickets', $property->id_wisata) }}" method="GET" class="search-filter-form" style="margin: 0;">
            <input type="text" name="search" class="search-input" placeholder="Search Ticket..." value="{{ request('search') }}" style="width: 250px; padding: 8px 15px; border-radius: 20px; border: 1px solid #ccc;">
        </form>

    </div>

    <div class="property-list">
        
        @forelse($tickets as $ticket)
            <div class="property-card ticket-card-item">
                
                <div class="card-image">
                    @if($ticket->foto_tiket)
                        <img src="{{ Str::startsWith($ticket->foto_tiket, 'http') ? $ticket->foto_tiket : asset($ticket->foto_tiket) }}" alt="{{ $ticket->nama_paket }}">
                    @else
                        <img src="{{ asset('images/default_ticket.jpg') }}" alt="Ticket">
                    @endif
                </div>

                <div class="card-info">
                    <h3 class="prop-name">{{ $ticket->nama_tiket }}</h3> <div class="ticket-price">
                        Rp. {{ number_format($ticket->harga, 0, ',', '.') }}
                    </div>

                    <div class="prop-details" style="margin-top: 5px;">
                        <i class="fas fa-user-friends"></i> 1 person (default)
                    </div>

                    <div class="prop-tickets">
                        <i class="fas fa-ticket-alt"></i> 
                        {{ $ticket->jumlah }} tickets
                    </div>
                </div>

                <div class="card-actions">
                    <a href="{{ route('tickets.ptw.edit', $ticket->id_paket ?? $ticket->id_tiket) }}" class="btn-action btn-edit">
                        Edit
                    </a>

                    <form action="{{ route('tickets.ptw.destroy', $ticket->id_paket ?? $ticket->id_tiket) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-action btn-delete" onclick="return confirm('Are you sure you want to delete this ticket?')">
                            Delete
                        </button>
                    </form>
                </div>

            </div>
        @empty
            <div class="empty-state">
                <p>There is no ticket yet. Please add at least one ticket.</p>
            </div>
        @endforelse

    </div>

</div>

@endsection
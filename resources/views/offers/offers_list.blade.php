@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Offers</h2>
        <div class="d-flex justify-content-end mt-3">
            <a href="{{ route('offers.get.create') }}" class="btn btn-success mb-3">Create Offer</a>
        </div>

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (count($offers) > 0)
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Number</th>
                        <th>Insurance Bonus</th>
                        <th>Created At</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($offers as $offer)
                        <tr>
                            <td>{{ $offer->id }}</td>
                            <td>{{ $offer->insurance_bonus }}</td>
                            <td>{{ $offer->created_at->format('Y-m-d') }}</td>
                            <td>
                                <a href="{{ route('offers.get.update', $offer->id) }}" class="btn btn-primary">Edit offer</a>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal{{ $offer->id }}">
                                    Delete
                                </button>
                            </td>
                            <td>
                                <a href="{{ route('offers.details', $offer->id) }}" class="btn btn-secondary">See
                                    Details</a>
                            </td>
                        </tr>
                        <div class="modal fade" id="offerModal{{ $offer->id }}" tabindex="-1"
                            aria-labelledby="offerModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="offerModalLabel">Offer Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="deleteModal{{ $offer->id }}" tabindex="-1"
                            aria-labelledby="deleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to delete this offer?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <form action="{{ route('offers.delete', $offer->id) }}" method="POST">
                                            @csrf
                                            @method('POST')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

            </table>
            <div class="d-flex justify-content-end">
                {!! $offers->withQueryString()->links('pagination::bootstrap-5') !!}
            </div>
        @else
            <div class="text-center mt-4">
                <h3>No offers could be found under your name!</h3>
            </div>
        @endif
    </div>
@endsection

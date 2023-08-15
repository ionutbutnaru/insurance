@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-end mt-3">
            <a href="{{ route('offers.offers_list') }}" class="btn btn-secondary me-2">All Offers</a>
            <a href="{{ route('home') }}" class="btn btn-primary">Home</a>
        </div>
        <h2>Offer Details</h2>
        <table class="table">
            <tr>
                <th>ID:</th>
                <td>{{ $offer->id }}</td>
            </tr>
            <tr>
                <th>Insured Name:</th>
                <td>{{ $offer->insured_name }}</td>
            </tr>
            <tr>
                <th>Insurance Bonus:</th>
                <td>{{ $offer->insurance_bonus }}</td>
            </tr>

            <tr>
                <th>Admin:</th>
                <td>{{ $offer->user->name }}</td>
            </tr>
            <tr>
                <th>CNP:</th>
                <td>{{ $offer->insured_cnp }}</td>
            </tr>
            <tr>
                <th>Created At:</th>
                <td>{{ $offer->created_at->format('Y-m-d') }}</td>
            </tr>
            <tr>
                <th>Last Updated At:</th>
                <td>{{ $offer->updated_at->format('Y-m-d') }}</td>
            </tr>
        </table>
    </div>
@endsection

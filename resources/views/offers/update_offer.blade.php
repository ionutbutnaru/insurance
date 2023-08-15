@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-end mt-3">
            <a href="{{ route('offers.offers_list') }}" class="btn btn-secondary me-2">All Offers</a>
            <a href="{{ route('home') }}" class="btn btn-primary">Home</a>
        </div>
        <h2>Edit Offer</h2>
        <form method="post" action="{{ route('offers.update', $offer->id) }}">
            @csrf
            @method('POST')
            <div class="mb-3">
                <label for="insurance_bonus" class="form-label">Insurance Bonus</label>
                <input type="text" class="form-control @error('insurance_bonus') is-invalid @enderror"
                    id="insurance_bonus" name="insurance_bonus"
                    value="{{ old('insurance_bonus', $offer->insurance_bonus) }}">
                @error('insurance_bonus')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="insured_cnp" class="form-label">Insured CNP</label>
                <input type="text" class="form-control @error('insured_cnp') is-invalid @enderror" id="insured_cnp"
                    name="insured_cnp" value="{{ old('insured_cnp', $offer->insured_cnp) }}">
                @error('insured_cnp')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="insured_name" class="form-label">Insured Name</label>
                <input type="text" class="form-control @error('insured_name') is-invalid @enderror" id="insured_name"
                    name="insured_name" value="{{ old('insured_name', $offer->insured_name) }}">
                @error('insured_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                @if ($validationErrors)
                    <div class="alert alert-danger mt-2">
                        <ul class="cnp-errors">
                            @foreach ($validationErrors as $error)
                                <li class="">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Update Offer</button>
        </form>
    </div>
@endsection
<style>
    .alert.alert-danger {
        background-color: var(--bs-body-bg);
        border: none;
        color: #dc3545;
        padding: 0;
        margin: 0;
    }

    .alert ul li {
        list-style: none;
        position: relative;
    }
</style>

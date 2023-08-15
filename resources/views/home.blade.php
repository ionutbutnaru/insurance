@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="d-flex justify-content-center mt-4">
                    <a href="{{ route('offers.offers_list')}}"
                        class="btn btn-dark">
                        Offers
                    </a>
                   </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h1>Welcome to SecureShield Insurance</h1>
                                    <p>Your Trusted Partner for Comprehensive Insurance Solutions</p>
                                    <p>At SecureShield Insurance, we are committed to providing you with the best insurance coverage tailored to your needs. With a team of experienced professionals and a wide range of insurance options, we ensure peace of mind for you and your loved ones.</p>
                                    <p>Whether you're looking for life insurance, auto insurance, home insurance, or any other type of coverage, we've got you covered. Our mission is to offer you reliable protection and exceptional customer service, making us your preferred insurance provider.</p>

                                </div>

                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

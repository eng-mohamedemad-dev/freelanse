@extends('website.layouts.app')

@section('title', __('website.home'))

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="hero-title">{{ __('website.welcome_message') }}</h1>
                <p class="hero-description">{{ __('website.hero_description') }}</p>
                <div class="hero-buttons">
                    <a href="{{ route('website.products.index') }}" class="btn btn-primary btn-lg">
                        {{ __('website.shop_now') }}
                    </a>
                    <a href="{{ route('website.about') }}" class="btn btn-outline-primary btn-lg">
                        {{ __('website.learn_more') }}
                    </a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="hero-image">
                    <img src="{{ asset('assets/website/images/hero-image.jpg') }}" alt="Hero Image" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="featured-products">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="section-title">{{ __('website.featured_products') }}</h2>
                <p class="section-description">{{ __('website.featured_products_description') }}</p>
            </div>
        </div>
        <div class="row">
            @forelse($featuredProducts ?? [] as $product)
            <div class="col-md-3">
                <div class="product-card">
                    <div class="product-image">
                        <img src="{{ $product->image ?? asset('assets/website/images/placeholder.jpg') }}" alt="{{ $product->name }}">
                        <div class="product-overlay">
                            <a href="{{ route('website.products.show', $product) }}" class="btn btn-primary">
                                {{ __('website.view_details') }}
                            </a>
                        </div>
                    </div>
                    <div class="product-info">
                        <h5 class="product-title">{{ $product->name }}</h5>
                        <p class="product-price">${{ number_format($product->price, 2) }}</p>
                        <div class="product-actions">
                            <button class="btn btn-primary add-to-cart" data-product-id="{{ $product->id }}">
                                <i class="fa fa-shopping-cart"></i> {{ __('website.add_to_cart') }}
                            </button>
                            <button class="btn btn-outline-primary add-to-wishlist" data-product-id="{{ $product->id }}">
                                <i class="fa fa-heart"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-md-12">
                <p class="text-center text-muted">{{ __('website.no_products') }}</p>
            </div>
            @endforelse
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <a href="{{ route('website.products.index') }}" class="btn btn-outline-primary">
                    {{ __('website.view_all_products') }}
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Categories -->
<section class="categories-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="section-title">{{ __('website.categories') }}</h2>
                <p class="section-description">{{ __('website.categories_description') }}</p>
            </div>
        </div>
        <div class="row">
            @forelse($categories ?? [] as $category)
            <div class="col-md-4">
                <div class="category-card">
                    <div class="category-image">
                        <img src="{{ $category->image ?? asset('assets/website/images/category-placeholder.jpg') }}" alt="{{ $category->name }}">
                    </div>
                    <div class="category-info">
                        <h4 class="category-title">{{ $category->name }}</h4>
                        <p class="category-description">{{ $category->description }}</p>
                        <a href="{{ route('website.categories.show', $category) }}" class="btn btn-outline-primary">
                            {{ __('website.explore_category') }}
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-md-12">
                <p class="text-center text-muted">{{ __('website.no_categories') }}</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Newsletter -->
<section class="newsletter-section">
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto text-center">
                <h2 class="newsletter-title">{{ __('website.newsletter_title') }}</h2>
                <p class="newsletter-description">{{ __('website.newsletter_description') }}</p>
                <form class="newsletter-form" action="{{ route('website.newsletter.subscribe') }}" method="POST">
                    @csrf
                    <div class="input-group">
                        <input type="email" name="email" class="form-control" placeholder="{{ __('website.email_placeholder') }}" required>
                        <button class="btn btn-primary" type="submit">
                            {{ __('website.subscribe') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.hero-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 4rem 0;
    margin-bottom: 3rem;
}

.hero-title {
    font-size: 3rem;
    font-weight: bold;
    margin-bottom: 1rem;
}

.hero-description {
    font-size: 1.2rem;
    margin-bottom: 2rem;
    opacity: 0.9;
}

.hero-buttons {
    display: flex;
    gap: 1rem;
}

.hero-image img {
    border-radius: 10px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
}

.section-title {
    text-align: center;
    font-size: 2.5rem;
    margin-bottom: 1rem;
    color: #333;
}

.section-description {
    text-align: center;
    color: #666;
    margin-bottom: 3rem;
}

.featured-products {
    padding: 3rem 0;
    background-color: #f8f9fa;
}

.categories-section {
    padding: 3rem 0;
}

.category-card {
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    margin-bottom: 2rem;
    transition: transform 0.3s ease;
}

.category-card:hover {
    transform: translateY(-5px);
}

.category-image img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.category-info {
    padding: 1.5rem;
}

.category-title {
    font-size: 1.5rem;
    margin-bottom: 1rem;
    color: #333;
}

.category-description {
    color: #666;
    margin-bottom: 1rem;
}

.newsletter-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 3rem 0;
    margin-top: 3rem;
}

.newsletter-title {
    font-size: 2.5rem;
    margin-bottom: 1rem;
}

.newsletter-description {
    font-size: 1.2rem;
    margin-bottom: 2rem;
    opacity: 0.9;
}

.newsletter-form .input-group {
    max-width: 500px;
    margin: 0 auto;
}

.newsletter-form .form-control {
    border-radius: 25px 0 0 25px;
    border-right: none;
    padding: 0.75rem 1rem;
}

.newsletter-form .btn {
    border-radius: 0 25px 25px 0;
    border-left: none;
    padding: 0.75rem 1.5rem;
}

@media (max-width: 768px) {
    .hero-title {
        font-size: 2rem;
    }
    
    .hero-buttons {
        flex-direction: column;
    }
    
    .section-title {
        font-size: 2rem;
    }
}
</style>
@endpush

@extends('website.layouts.app')

@section('title', __('website.home'))

@section('content')
<!-- Hero Section -->
<section class="hero-section">
  <div class="container">
    <div class="hero-content">
      <div class="hero-text">
        <h1 class="hero-title">{{ __('website.welcome_title') }}</h1>
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
      <div class="hero-image">
        <img src="{{ asset('assets/website/images/hero-image.png') }}" alt="Hero Image" class="img-fluid">
      </div>
    </div>
  </div>
</section>

<!-- Features Section -->
<section class="features-section">
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <div class="feature-item">
          <div class="feature-icon">
            <i class="fa fa-shipping-fast"></i>
          </div>
          <h3>{{ __('website.free_shipping') }}</h3>
          <p>{{ __('website.free_shipping_description') }}</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="feature-item">
          <div class="feature-icon">
            <i class="fa fa-shield-alt"></i>
          </div>
          <h3>{{ __('website.secure_payment') }}</h3>
          <p>{{ __('website.secure_payment_description') }}</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="feature-item">
          <div class="feature-icon">
            <i class="fa fa-headset"></i>
          </div>
          <h3>{{ __('website.customer_support') }}</h3>
          <p>{{ __('website.customer_support_description') }}</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Featured Products Section -->
<section class="featured-products-section">
  <div class="container">
    <div class="section-header">
      <h2 class="section-title">{{ __('website.featured_products') }}</h2>
      <p class="section-description">{{ __('website.featured_products_description') }}</p>
    </div>
    
    <div class="products-grid">
      @forelse($featuredProducts as $product)
        <div class="product-card">
          <div class="product-image">
            <img src="{{ $product->getFirstMediaUrl('images') ?: asset('assets/website/images/product-placeholder.jpg') }}" 
                 alt="{{ $product->name }}" class="img-fluid">
            <div class="product-overlay">
              <a href="{{ route('website.products.show', $product) }}" class="btn btn-primary">
                {{ __('website.view_details') }}
              </a>
            </div>
          </div>
          <div class="product-info">
            <h3 class="product-name">{{ $product->name }}</h3>
            <p class="product-price">{{ number_format($product->price, 2) }} {{ __('website.currency') }}</p>
            <div class="product-actions">
              <a href="{{ route('website.cart.add', $product) }}" class="btn btn-outline-primary">
                <i class="fa fa-shopping-cart"></i> {{ __('website.add_to_cart') }}
              </a>
              <a href="{{ route('website.quick-order', $product) }}" class="btn btn-primary">
                <i class="fa fa-bolt"></i> {{ __('website.quick_order') }}
              </a>
            </div>
          </div>
        </div>
      @empty
        <div class="col-12">
          <div class="text-center">
            <p>{{ __('website.no_products') }}</p>
          </div>
        </div>
      @endforelse
    </div>
    
    <div class="text-center">
      <a href="{{ route('website.products.index') }}" class="btn btn-primary btn-lg">
        {{ __('website.view_all_products') }}
      </a>
    </div>
  </div>
</section>

<!-- Categories Section -->
<section class="categories-section">
  <div class="container">
    <div class="section-header">
      <h2 class="section-title">{{ __('website.categories') }}</h2>
      <p class="section-description">{{ __('website.categories_description') }}</p>
    </div>
    
    <div class="categories-grid">
      @forelse($categories as $category)
        <div class="category-card">
          <div class="category-image">
            <img src="{{ $category->getFirstMediaUrl('images') ?: asset('assets/website/images/category-placeholder.jpg') }}" 
                 alt="{{ $category->name }}" class="img-fluid">
          </div>
          <div class="category-info">
            <h3 class="category-name">{{ $category->name }}</h3>
            <p class="category-description">{{ $category->description }}</p>
            <a href="{{ route('website.categories.show', $category) }}" class="btn btn-outline-primary">
              {{ __('website.view_products') }}
            </a>
          </div>
        </div>
      @empty
        <div class="col-12">
          <div class="text-center">
            <p>{{ __('website.no_categories') }}</p>
          </div>
        </div>
      @endforelse
    </div>
  </div>
</section>

<!-- Newsletter Section -->
<section class="newsletter-section">
  <div class="container">
    <div class="newsletter-content">
      <div class="newsletter-text">
        <h2>{{ __('website.newsletter_title') }}</h2>
        <p>{{ __('website.newsletter_description') }}</p>
      </div>
      <div class="newsletter-form">
        <form action="{{ route('website.newsletter.subscribe') }}" method="POST">
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
  padding: 100px 0;
  min-height: 600px;
  display: flex;
  align-items: center;
}

.hero-content {
  display: flex;
  align-items: center;
  gap: 50px;
}

.hero-text {
  flex: 1;
}

.hero-title {
  font-size: 3.5rem;
  font-weight: 700;
  margin-bottom: 1.5rem;
  line-height: 1.2;
}

.hero-description {
  font-size: 1.25rem;
  margin-bottom: 2rem;
  opacity: 0.9;
}

.hero-buttons {
  display: flex;
  gap: 1rem;
  flex-wrap: wrap;
}

.hero-image {
  flex: 1;
  text-align: center;
}

.hero-image img {
  max-width: 100%;
  height: auto;
}

.features-section {
  padding: 80px 0;
  background: #f8f9fa;
}

.feature-item {
  text-align: center;
  padding: 2rem;
}

.feature-icon {
  font-size: 3rem;
  color: #007bff;
  margin-bottom: 1.5rem;
}

.feature-item h3 {
  font-size: 1.5rem;
  margin-bottom: 1rem;
  color: #333;
}

.feature-item p {
  color: #666;
  line-height: 1.6;
}

.featured-products-section {
  padding: 80px 0;
}

.section-header {
  text-align: center;
  margin-bottom: 4rem;
}

.section-title {
  font-size: 2.5rem;
  font-weight: 700;
  margin-bottom: 1rem;
  color: #333;
}

.section-description {
  font-size: 1.125rem;
  color: #666;
  max-width: 600px;
  margin: 0 auto;
}

.products-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 2rem;
  margin-bottom: 3rem;
}

.product-card {
  background: white;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.product-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.product-image {
  position: relative;
  overflow: hidden;
  height: 250px;
}

.product-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.product-overlay {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.7);
  display: flex;
  align-items: center;
  justify-content: center;
  opacity: 0;
  transition: opacity 0.3s ease;
}

.product-card:hover .product-overlay {
  opacity: 1;
}

.product-info {
  padding: 1.5rem;
}

.product-name {
  font-size: 1.25rem;
  font-weight: 600;
  margin-bottom: 0.5rem;
  color: #333;
}

.product-price {
  font-size: 1.125rem;
  font-weight: 700;
  color: #007bff;
  margin-bottom: 1rem;
}

.product-actions {
  display: flex;
  gap: 0.5rem;
  flex-wrap: wrap;
}

.product-actions .btn {
  flex: 1;
  min-width: 120px;
}

.categories-section {
  padding: 80px 0;
  background: #f8f9fa;
}

.categories-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 2rem;
}

.category-card {
  background: white;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease;
}

.category-card:hover {
  transform: translateY(-5px);
}

.category-image {
  height: 200px;
  overflow: hidden;
}

.category-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.category-info {
  padding: 1.5rem;
  text-align: center;
}

.category-name {
  font-size: 1.25rem;
  font-weight: 600;
  margin-bottom: 0.5rem;
  color: #333;
}

.category-description {
  color: #666;
  margin-bottom: 1rem;
  line-height: 1.6;
}

.newsletter-section {
  padding: 80px 0;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
}

.newsletter-content {
  display: flex;
  align-items: center;
  gap: 3rem;
  flex-wrap: wrap;
}

.newsletter-text {
  flex: 1;
  min-width: 300px;
}

.newsletter-text h2 {
  font-size: 2.5rem;
  font-weight: 700;
  margin-bottom: 1rem;
}

.newsletter-text p {
  font-size: 1.125rem;
  opacity: 0.9;
}

.newsletter-form {
  flex: 1;
  min-width: 300px;
}

.newsletter-form .input-group {
  display: flex;
  gap: 0;
}

.newsletter-form .form-control {
  border-radius: 5px 0 0 5px;
  border: none;
  padding: 1rem;
  font-size: 1rem;
}

.newsletter-form .btn {
  border-radius: 0 5px 5px 0;
  padding: 1rem 2rem;
  font-weight: 600;
}

@media (max-width: 768px) {
  .hero-content {
    flex-direction: column;
    text-align: center;
  }
  
  .hero-title {
    font-size: 2.5rem;
  }
  
  .hero-buttons {
    justify-content: center;
  }
  
  .newsletter-content {
    flex-direction: column;
    text-align: center;
  }
  
  .newsletter-form .input-group {
    flex-direction: column;
  }
  
  .newsletter-form .form-control,
  .newsletter-form .btn {
    border-radius: 5px;
  }
}
</style>
@endpush
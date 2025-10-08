# تنظيم Routes و Controllers - Best Practices

## 🎯 المبادئ المتبعة

### 1. **Resource Routes**
استخدام `Route::resource` بدلاً من كتابة كل route منفرد:

```php
// ❌ الطريقة القديمة
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

// ✅ الطريقة الجديدة
Route::resource('products', ProductController::class);
```

### 2. **Route Groups**
تنظيم Routes في مجموعات منطقية:

```php
// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('orders', OrderController::class);
});

// Website Routes
Route::prefix('cart')->name('website.cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::post('/update', [CartController::class, 'update'])->name('update');
});
```

### 3. **Resource Controllers**
استخدام Resource Controllers مع الطرق القياسية:

```php
class ProductController extends Controller
{
    public function index()     // GET /products
    public function create()    // GET /products/create
    public function store()     // POST /products
    public function show()      // GET /products/{product}
    public function edit()      // GET /products/{product}/edit
    public function update()    // PUT/PATCH /products/{product}
    public function destroy()   // DELETE /products/{product}
}
```

## 📁 بنية Routes المنظمة

### Admin Routes (`routes/admin.php`)

```php
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Resource Routes
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('brands', BrandController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('users', UserController::class);
    
    // Additional Routes for Products
    Route::post('products/{product}/toggle-status', [ProductController::class, 'toggleStatus']);
    Route::post('products/bulk-action', [ProductController::class, 'bulkAction']);
    
    // Additional Routes for Orders
    Route::post('orders/{order}/mark-completed', [OrderController::class, 'markAsCompleted']);
    Route::post('orders/{order}/mark-cancelled', [OrderController::class, 'markAsCancelled']);
    
    // Settings (Non-resource)
    Route::get('settings', [SettingController::class, 'index'])->name('settings');
    Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
});
```

### Website Routes (`routes/website.php`)

```php
// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('website.home');

// Resource Routes
Route::resource('products', ProductController::class)->only(['index', 'show']);
Route::resource('categories', CategoryController::class)->only(['index', 'show']);

// Cart Routes
Route::prefix('cart')->name('website.cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::post('/update', [CartController::class, 'update'])->name('update');
    Route::post('/remove', [CartController::class, 'remove'])->name('remove');
});

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::prefix('account')->name('website.account.')->group(function () {
        Route::get('/', [AccountController::class, 'dashboard'])->name('dashboard');
        Route::resource('addresses', AccountController::class)->except(['show']);
    });
});
```

## 🎯 فوائد التنظيم الجديد

### 1. **Clean Code**
- كود أقل وأوضح
- سهولة القراءة والفهم
- تقليل التكرار

### 2. **Maintainability**
- سهولة الصيانة
- إضافة routes جديدة بسهولة
- تنظيم منطقي

### 3. **Best Practices**
- اتباع معايير Laravel
- Resource Controllers القياسية
- Route Model Binding

### 4. **Performance**
- تحميل أسرع
- ذاكرة أقل
- كفاءة أعلى

## 📋 قائمة Controllers المنظمة

### Admin Controllers
- `DashboardController` - لوحة التحكم
- `ProductController` - إدارة المنتجات
- `CategoryController` - إدارة الفئات
- `BrandController` - إدارة العلامات التجارية
- `OrderController` - إدارة الطلبات
- `UserController` - إدارة المستخدمين
- `SettingController` - الإعدادات

### Website Controllers
- `HomeController` - الصفحة الرئيسية
- `ProductController` - عرض المنتجات
- `CategoryController` - عرض الفئات
- `CartController` - سلة التسوق
- `WishlistController` - قائمة الأمنيات
- `CheckoutController` - عملية الدفع
- `AccountController` - حساب المستخدم
- `AuthController` - المصادقة
- `SearchController` - البحث
- `OrderController` - الطلبات
- `WheelController` - عجلة الحظ
- `QuickOrderController` - الطلبات السريعة

## 🔧 استخدام Templates الموجودة

يمكن الآن استخدام الـ HTML templates الموجودة في مجلد `commerce/`:

### Admin Templates
- `commerce/Admin/index.html` → `resources/views/admin/dashboard.blade.php`
- `commerce/Admin/products.html` → `resources/views/admin/products/index.blade.php`
- `commerce/Admin/add-product.html` → `resources/views/admin/products/create.blade.php`

### Website Templates
- `commerce/Website/index.html` → `resources/views/website/home.blade.php`
- `commerce/Website/shop.html` → `resources/views/website/products/index.blade.php`
- `commerce/Website/cart.html` → `resources/views/website/cart/index.blade.php`

## 🚀 الخطوات التالية

1. **تحويل HTML إلى Blade**
2. **استخدام Assets الموجودة**
3. **تطبيق التصميم على Views**
4. **اختبار جميع Routes**
5. **تحسين الأداء**

---

**هذا التنظيم يتبع أفضل الممارسات في Laravel ويجعل المشروع أكثر تنظيماً وسهولة في الصيانة**

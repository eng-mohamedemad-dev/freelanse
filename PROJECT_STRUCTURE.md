# هيكل المشروع - متجر إلكتروني

## نظرة عامة
تم تنظيم المشروع ليكون متجر إلكتروني متكامل مع لوحة تحكم للادمن وموقع للعملاء، مع دعم كامل للغة العربية والإنجليزية.

## بنية المجلدات

### 1. Views (العروض)
```
resources/views/
├── admin/                    # عروض لوحة التحكم
│   ├── layouts/
│   │   └── app.blade.php     # التخطيط الأساسي للادمن
│   ├── dashboard.blade.php   # لوحة التحكم الرئيسية
│   ├── products/             # إدارة المنتجات
│   │   ├── index.blade.php   # قائمة المنتجات
│   │   ├── create.blade.php  # إضافة منتج
│   │   ├── edit.blade.php    # تعديل منتج
│   │   └── show.blade.php    # عرض منتج
│   ├── categories/           # إدارة الفئات
│   ├── brands/               # إدارة العلامات التجارية
│   ├── orders/              # إدارة الطلبات
│   └── users/               # إدارة المستخدمين
│
└── website/                 # عروض الموقع
    ├── layouts/
    │   └── app.blade.php     # التخطيط الأساسي للموقع
    ├── home.blade.php        # الصفحة الرئيسية
    ├── products/             # صفحات المنتجات
    │   ├── index.blade.php   # قائمة المنتجات
    │   └── show.blade.php    # تفاصيل المنتج
    ├── auth/                 # صفحات المصادقة
    │   ├── login.blade.php   # تسجيل الدخول
    │   └── register.blade.php # إنشاء حساب
    ├── cart/                 # سلة التسوق
    ├── checkout/             # صفحة الدفع
    └── account/              # حساب المستخدم
```

### 2. Assets (الموارد)
```
public/assets/
├── admin/                    # موارد لوحة التحكم
│   ├── css/
│   │   ├── admin.css         # أنماط الادمن
│   │   ├── bootstrap.min.css # Bootstrap
│   │   └── font-awesome.min.css # Font Awesome
│   ├── js/
│   │   ├── admin.js          # JavaScript للادمن
│   │   ├── jquery.min.js     # jQuery
│   │   └── bootstrap.bundle.min.js # Bootstrap JS
│   └── images/               # صور الادمن
│
└── website/                 # موارد الموقع
    ├── css/
    │   ├── style.css         # أنماط الموقع
    │   ├── bootstrap.min.css # Bootstrap
    │   └── font-awesome.min.css # Font Awesome
    ├── js/
    │   ├── main.js           # JavaScript للموقع
    │   ├── jquery.min.js     # jQuery
    │   └── bootstrap.bundle.min.js # Bootstrap JS
    └── images/                # صور الموقع
```

### 3. Routes (المسارات)
```
routes/
├── web.php                   # المسارات الرئيسية
├── admin.php                 # مسارات لوحة التحكم
└── website.php               # مسارات الموقع
```

### 4. Languages (الترجمة)
```
lang/
├── ar/                       # اللغة العربية
│   ├── admin.php             # ترجمة لوحة التحكم
│   └── website.php           # ترجمة الموقع
└── en/                       # اللغة الإنجليزية
    ├── admin.php             # ترجمة لوحة التحكم
    └── website.php           # ترجمة الموقع
```

## الميزات الرئيسية

### لوحة التحكم (Admin Panel)
- **لوحة تحكم شاملة** مع إحصائيات مفصلة
- **إدارة المنتجات** (إضافة، تعديل، حذف، عرض)
- **إدارة الفئات** والعلامات التجارية
- **إدارة الطلبات** والمستخدمين
- **نظام البحث والتصفية** المتقدم
- **إجراءات جماعية** للمنتجات
- **تصدير البيانات** والتقارير

### الموقع (Website)
- **صفحة رئيسية جذابة** مع منتجات مميزة
- **قائمة منتجات متقدمة** مع فلاتر متعددة
- **صفحة تفاصيل المنتج** مع صور ومعاينة
- **سلة تسوق متكاملة** مع إدارة الكميات
- **نظام أمنيات** للمنتجات
- **حساب مستخدم** مع إدارة الطلبات
- **نظام دفع متكامل**

### نظام الترجمة
- **دعم كامل للعربية والإنجليزية**
- **تبديل سهل للغة** من أي صفحة
- **ترجمة شاملة** لجميع النصوص
- **دعم RTL** للعربية

## التقنيات المستخدمة

### Frontend
- **HTML5** و **CSS3**
- **Bootstrap 5** للتصميم المتجاوب
- **Font Awesome** للأيقونات
- **JavaScript** و **jQuery** للتفاعل
- **تصميم متجاوب** لجميع الأجهزة

### Backend
- **Laravel 10** إطار العمل
- **Blade Templates** للعروض
- **Eloquent ORM** لقاعدة البيانات
- **Middleware** للأمان
- **Validation** للتحقق من البيانات

## كيفية الاستخدام

### 1. تثبيت المشروع
```bash
composer install
npm install
```

### 2. إعداد قاعدة البيانات
```bash
php artisan migrate
php artisan db:seed
```

### 3. تشغيل المشروع
```bash
php artisan serve
```

### 4. الوصول للوحة التحكم
```
http://localhost:8000/admin
```

### 5. الوصول للموقع
```
http://localhost:8000
```

## الملفات المهمة

### Layouts
- `resources/views/admin/layouts/app.blade.php` - تخطيط الادمن
- `resources/views/website/layouts/app.blade.php` - تخطيط الموقع

### CSS الرئيسي
- `public/assets/admin/css/admin.css` - أنماط الادمن
- `public/assets/website/css/style.css` - أنماط الموقع

### JavaScript
- `public/assets/admin/js/admin.js` - JavaScript الادمن
- `public/assets/website/js/main.js` - JavaScript الموقع

### الترجمة
- `lang/ar/admin.php` - ترجمة الادمن (عربي)
- `lang/ar/website.php` - ترجمة الموقع (عربي)
- `lang/en/admin.php` - ترجمة الادمن (إنجليزي)
- `lang/en/website.php` - ترجمة الموقع (إنجليزي)

## التطوير المستقبلي

### ميزات مخططة
- **نظام تقييمات** للمنتجات
- **نظام كوبونات** وخصومات
- **نظام إشعارات** متقدم
- **تكامل مع بوابات الدفع**
- **نظام توصيل** متقدم
- **تطبيق موبايل** مصاحب

### تحسينات الأداء
- **تخزين مؤقت** للصفحات
- **ضغط الصور** التلقائي
- **تحسين قاعدة البيانات**
- **CDN** للموارد الثابتة

## الدعم والمساعدة

لأي استفسارات أو مشاكل، يرجى التواصل مع فريق التطوير.

---
**تم إنشاء هذا المشروع باستخدام Laravel 10 و Bootstrap 5**

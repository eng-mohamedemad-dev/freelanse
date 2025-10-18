@extends('website.layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">إتمام الطلب</h2>
    <div class="row g-4">
        <div class="col-md-7">
            <form method="POST" action="{{ route('website.checkout.store') }}" class="card card-body">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">الاسم الكامل</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">البريد الإلكتروني (اختياري)</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">رقم الهاتف</label>
                        <input type="text" name="phone" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">رقم الواتساب</label>
                        <input type="text" name="whatsapp" class="form-control" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">العنوان التفصيلي</label>
                        <textarea name="address" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">ملاحظات (اختياري)</label>
                        <textarea name="notes" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">كوبون خصم (اختياري)</label>
                        <input type="text" name="coupon_code" class="form-control" placeholder="إن وجد">
                    </div>
                </div>
                <div class="mt-3">
                    <button class="btn btn-success" type="submit">إرسال الطلب</button>
                </div>
            </form>
        </div>
        <div class="col-md-5">
            <div class="card card-body">
                <h6 class="mb-3">ملخص الطلب</h6>
                <div class="mb-2 d-flex justify-content-between"><span>المجموع</span><span>{{ number_format($totals['subtotal'], 2) }}</span></div>
                <div class="mb-2 d-flex justify-content-between"><span>الخصم</span><span>{{ number_format($totals['discount'], 2) }}</span></div>
                <div class="mb-2 d-flex justify-content-between fw-bold"><span>الإجمالي</span><span>{{ number_format($totals['total'], 2) }}</span></div>
            </div>
        </div>
    </div>
</div>
@endsection



@extends('admin.layouts.app')

@section('title', __('admin.notifications'))
@section('page-title', __('admin.notifications'))

@section('content')
<div class="wg-box">
        <div class="flex items-center justify-between mb-20" style="background: linear-gradient(135deg, #667eea, #764ba2); color: white; padding: 20px; margin: -20px -20px 20px -20px; border-radius: 16px 16px 0 0; width: calc(100% + 40px);">
            <h5 style="color: white; font-size: 24px; font-weight: 700; margin: 0;">
                <i class="icon-bell" style="margin-left: 10px; font-size: 28px;"></i>{{ __('admin.notifications') }}
            </h5>
            <div class="flex items-center gap-3">
                <button class="btn btn-outline-primary" id="mark-all-read-btn" style="background: rgba(255, 255, 255, 0.2); border: 2px solid white; color: white; border-radius: 12px; padding: 12px 20px; font-weight: 600; transition: all 0.3s ease;">
                    <i class="icon-check" style="font-size: 18px; margin-left: 8px;"></i>
                    {{ __('admin.mark_all_read') }}
                </button>
                <button class="btn btn-outline-danger" id="delete-all-read-btn" style="background: rgba(239, 68, 68, 0.2); border: 2px solid #ef4444; color: #ef4444; border-radius: 12px; padding: 12px 20px; font-weight: 600; transition: all 0.3s ease;">
                    <i class="icon-trash" style="font-size: 18px; margin-left: 8px;"></i>
                    {{ __('admin.delete_read') }}
                </button>
            </div>
        </div>
        
        <div class="notifications-list" style="width: 100%;">
            @if($notifications->count() > 0)
                @foreach($notifications as $notification)
                    <div class="notification-item {{ $notification->is_read ? 'read' : 'unread' }}" data-id="{{ $notification->id }}" style="background: linear-gradient(135deg, #ffffff, #f8f9fa); border: 1px solid #e9ecef; border-radius: 16px; padding: 20px; margin-bottom: 15px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05); transition: all 0.3s ease; position: relative; overflow: hidden; width: 100%; display: flex; align-items: flex-start;">
                        @if(!$notification->is_read)
                            <div style="position: absolute; top: 0; right: 0; width: 4px; height: 100%; background: linear-gradient(135deg, #667eea, #764ba2);"></div>
                        @endif
                        
                        <div class="notification-icon" style="width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg, #f3f4f6, #e5e7eb); display: flex; align-items: center; justify-content: center; margin-left: 15px; flex-shrink: 0; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                            @if($notification->type === 'warning')
                                <i class="icon-alert-triangle" style="color: #f39c12; font-size: 24px;"></i>
                            @elseif($notification->type === 'error')
                                <i class="icon-x-circle" style="color: #e74c3c; font-size: 24px;"></i>
                            @elseif($notification->type === 'success')
                                <i class="icon-check-circle" style="color: #27ae60; font-size: 24px;"></i>
                            @else
                                <i class="icon-info" style="color: #3498db; font-size: 24px;"></i>
                            @endif
                        </div>
                        
                        <div class="notification-content" style="flex: 1; min-width: 0;">
                            <div class="notification-title" style="font-weight: 700; font-size: 18px; color: #2c3e50; margin-bottom: 8px; display: flex; align-items: center; gap: 12px;">
                                {{ $notification->getLocalizedTitle(app()->getLocale()) }}
                                @if(!$notification->is_read)
                                    <span class="unread-badge" style="background: linear-gradient(135deg, #ff6b6b, #ee5a24); color: white; font-size: 11px; padding: 4px 10px; border-radius: 12px; font-weight: 600; box-shadow: 0 2px 4px rgba(255, 107, 107, 0.3);">جديد</span>
                                @endif
                            </div>
                            
                            <div class="notification-message" style="color: #6c757d; font-size: 15px; line-height: 1.6; margin-bottom: 12px;">
                                {{ $notification->getLocalizedMessage(app()->getLocale()) }}
                            </div>
                            
                            <div class="notification-meta" style="display: flex; align-items: center; gap: 20px; font-size: 13px; color: #9ca3af;">
                                <span class="notification-time" style="display: flex; align-items: center; gap: 5px;">
                                    <i class="icon-clock" style="font-size: 14px;"></i>
                                    {{ $notification->created_at->diffForHumans() }}
                                </span>
                                @if($notification->data && isset($notification->data['product_id']))
                                    <a href="{{ route('admin.products.show', $notification->data['product_id']) }}" class="notification-link" style="color: #667eea; text-decoration: none; font-weight: 600; display: flex; align-items: center; gap: 5px; transition: all 0.3s ease;">
                                        <i class="icon-eye" style="font-size: 14px;"></i>
                                        عرض المنتج
                                    </a>
                                @endif
                            </div>
                        </div>
                        
                        <div class="notification-actions" style="display: flex; align-items: center; gap: 8px; flex-shrink: 0;">
                            @if(!$notification->is_read)
                                <button class="btn btn-sm btn-outline-primary mark-read-btn" data-id="{{ $notification->id }}" style="background: linear-gradient(135deg, #667eea, #764ba2); border: none; color: white; border-radius: 10px; padding: 10px 15px; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 2px 4px rgba(102, 126, 234, 0.3);">
                                    <i class="icon-check" style="font-size: 16px;"></i>
                                </button>
                            @endif
                            <button class="btn btn-sm btn-outline-danger delete-notification-btn" data-id="{{ $notification->id }}" style="background: linear-gradient(135deg, #ff6b6b, #ee5a24); border: none; color: white; border-radius: 10px; padding: 10px 15px; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 2px 4px rgba(255, 107, 107, 0.3);">
                                <i class="icon-trash" style="font-size: 16px;"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
                
                <!-- Pagination -->
                <div class="mt-20">
                    {{ $notifications->links() }}
                </div>
            @else
                <div class="text-center py-40" style="background: linear-gradient(135deg, #f8f9fa, #e9ecef); border-radius: 16px; padding: 60px 20px; margin: 20px 0;">
                    <div style="width: 120px; height: 120px; background: linear-gradient(135deg, #667eea, #764ba2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 30px; box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);">
                        <i class="icon-bell-off" style="font-size: 60px; color: white;"></i>
                    </div>
                    <h4 style="color: #2c3e50; font-size: 24px; font-weight: 700; margin-bottom: 10px;">لا توجد إشعارات</h4>
                    <p style="color: #6c757d; font-size: 16px; margin: 0;">جميع الإشعارات ستظهر هنا عند توفرها</p>
                </div>
            @endif
        </div>
</div>
@endsection

@push('styles')
<style>
    /* SweetAlert2 Custom Styles */
    .swal-wide-popup {
        width: 500px !important;
        max-width: 90vw !important;
        padding: 2rem !important;
    }
    
    .swal-wide-title {
        font-size: 24px !important;
        font-weight: 700 !important;
        margin-bottom: 1rem !important;
    }
    
    .swal-wide-content {
        font-size: 16px !important;
        line-height: 1.6 !important;
    }
    
    .swal2-popup {
        border-radius: 16px !important;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2) !important;
    }
    
    .swal2-icon {
        margin: 20px auto 15px !important;
        width: 60px !important;
        height: 60px !important;
    }
    
    .swal2-icon .swal2-icon-content {
        font-size: 30px !important;
    }
    
    .swal2-actions {
        margin-top: 2rem !important;
        gap: 15px !important;
    }
    
    .swal2-confirm, .swal2-cancel {
        padding: 12px 30px !important;
        font-size: 16px !important;
        font-weight: 600 !important;
        border-radius: 10px !important;
        min-width: 120px !important;
    }
    
    .swal2-confirm {
        background: linear-gradient(135deg, #ef4444, #dc2626) !important;
        border: none !important;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3) !important;
    }
    
    .swal2-cancel {
        background: linear-gradient(135deg, #6b7280, #4b5563) !important;
        border: none !important;
        box-shadow: 0 4px 12px rgba(107, 114, 128, 0.3) !important;
    }
    
    .notifications-list {
        max-height: 600px;
        overflow-y: auto;
        width: 100% !important;
    }
    
    /* Ensure full width for notification items */
    .notification-item {
        width: 100% !important;
        max-width: 100% !important;
        box-sizing: border-box !important;
    }
    
    /* Ensure notifications take full width like products page */
    .wg-box {
        width: 100% !important;
        max-width: none !important;
        margin: 0 !important;
    }
    
    .notifications-list {
        width: 100% !important;
        max-width: none !important;
    }
    
    .notification-item {
        display: flex;
        align-items: flex-start;
        padding: 15px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        margin-bottom: 10px;
        background: #ffffff;
        transition: all 0.3s ease;
    }
    
    .notification-item:hover {
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .notification-item.unread {
        background: #fef3c7;
        border-color: #f59e0b;
    }
    
    .notification-item.read {
        background: #f9fafb;
        opacity: 0.8;
    }
    
    .notification-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-left: 15px;
        flex-shrink: 0;
    }
    
    .notification-content {
        flex: 1;
        min-width: 0;
    }
    
    .notification-title {
        font-weight: 600;
        font-size: 16px;
        color: #1f2937;
        margin-bottom: 5px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .unread-badge {
        background: #ef4444;
        color: white;
        font-size: 10px;
        padding: 2px 6px;
        border-radius: 10px;
        font-weight: 500;
    }
    
    .notification-message {
        color: #6b7280;
        font-size: 14px;
        line-height: 1.5;
        margin-bottom: 8px;
    }
    
    .notification-meta {
        display: flex;
        align-items: center;
        gap: 15px;
        font-size: 12px;
        color: #9ca3af;
    }
    
    .notification-link {
        color: #3b82f6;
        text-decoration: none;
        font-weight: 500;
    }
    
    .notification-link:hover {
        text-decoration: underline;
    }
    
    .notification-actions {
        display: flex;
        align-items: center;
        gap: 5px;
        flex-shrink: 0;
    }
    
    .notification-time {
        font-size: 12px;
        color: #9ca3af;
    }
    
    /* Dark theme */
    .dark-theme .notification-item {
        background: #374151;
        border-color: #4b5563;
    }
    
    .dark-theme .notification-item.unread {
        background: #451a03;
        border-color: #f59e0b;
    }
    
    .dark-theme .notification-item.read {
        background: #1f2937;
    }
    
    .dark-theme .notification-icon {
        background: #4b5563;
    }
    
    .dark-theme .notification-title {
        color: #f9fafb;
    }
    
    .dark-theme .notification-message {
        color: #d1d5db;
    }
    
    .dark-theme .notification-meta {
        color: #9ca3af;
    }
    
    /* Ensure full width for notifications like products page */
    .wg-box {
        width: 100% !important;
        max-width: none !important;
    }
    
    .notifications-list {
        width: 100% !important;
    }
    
    .notification-item {
        width: 100% !important;
    }
    
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Mark notification as read
    $('.mark-read-btn').on('click', function() {
        const notificationId = $(this).data('id');
        const notificationItem = $(this).closest('.notification-item');
        
        $.ajax({
            url: `/admin/notifications/${notificationId}/read`,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                notificationItem.removeClass('unread').addClass('read');
                notificationItem.find('.unread-badge').remove();
                notificationItem.find('.mark-read-btn').remove();
                
                Swal.fire({
                    icon: 'success',
                    title: 'تم',
                    text: response.message,
                    timer: 2000,
                    showConfirmButton: false
                });
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'خطأ',
                    text: 'حدث خطأ أثناء تحديث الإشعار',
                    confirmButtonText: 'موافق'
                });
            }
        });
    });
    
    // Delete notification
    $('.delete-notification-btn').on('click', function() {
        const notificationId = $(this).data('id');
        const notificationItem = $(this).closest('.notification-item');
        
        Swal.fire({
            title: 'تأكيد الحذف',
            text: 'هل أنت متأكد من حذف هذا الإشعار؟',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'نعم، احذف',
            cancelButtonText: 'إلغاء',
            confirmButtonColor: '#ef4444',
            width: '500px',
            padding: '2rem',
            customClass: {
                popup: 'swal-wide-popup',
                title: 'swal-wide-title',
                content: 'swal-wide-content'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/admin/notifications/${notificationId}`,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        notificationItem.fadeOut(300, function() {
                            $(this).remove();
                        });
                        
                        Swal.fire({
                            icon: 'success',
                            title: 'تم',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'خطأ',
                            text: 'حدث خطأ أثناء حذف الإشعار',
                            confirmButtonText: 'موافق'
                        });
                    }
                });
            }
        });
    });
    
    // Mark all as read
    $('#mark-all-read-btn').on('click', function() {
        Swal.fire({
            title: 'تأكيد',
            text: 'هل تريد تحديد جميع الإشعارات كمقروءة؟',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'نعم',
            cancelButtonText: 'إلغاء',
            width: '500px',
            padding: '2rem',
            customClass: {
                popup: 'swal-wide-popup',
                title: 'swal-wide-title',
                content: 'swal-wide-content'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/admin/notifications/read-all',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('.notification-item').removeClass('unread').addClass('read');
                        $('.unread-badge').remove();
                        $('.mark-read-btn').remove();
                        
                        Swal.fire({
                            icon: 'success',
                            title: 'تم',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'خطأ',
                            text: 'حدث خطأ أثناء تحديث الإشعارات',
                            confirmButtonText: 'موافق'
                        });
                    }
                });
            }
        });
    });
    
    // Delete all read notifications
    $('#delete-all-read-btn').on('click', function() {
        Swal.fire({
            title: 'تأكيد الحذف',
            text: 'هل تريد حذف جميع الإشعارات المقروءة؟',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'نعم، احذف',
            cancelButtonText: 'إلغاء',
            confirmButtonColor: '#ef4444',
            width: '500px',
            padding: '2rem',
            customClass: {
                popup: 'swal-wide-popup',
                title: 'swal-wide-title',
                content: 'swal-wide-content'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // This would need to be implemented in the controller
                Swal.fire({
                    icon: 'info',
                    title: 'قريباً',
                    text: 'هذه الميزة قيد التطوير',
                    confirmButtonText: 'موافق'
                });
            }
        });
    });
});
</script>
@endpush

<?php

namespace App\Services;

use App\Models\WheelPrize;
use App\Models\WheelSpin;
use App\Models\UserPoint;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class WheelService
{
    public function spinWheel($userId, $ipAddress, $userAgent)
    {
        // Check if wheel is enabled
        if (!Setting::getBoolean('wheel_enabled', false)) {
            return ['success' => false, 'message' => 'عجلة الحظ غير مفعلة حالياً'];
        }

        // Check if user has already spun today
        $todaySpins = WheelSpin::where('user_id', $userId)
            ->whereDate('created_at', today())
            ->count();

        $maxSpinsPerDay = Setting::getInteger('max_wheel_spins_per_day', 1);
        
        if ($todaySpins >= $maxSpinsPerDay) {
            return ['success' => false, 'message' => 'لقد استخدمت جميع محاولاتك اليوم'];
        }

        // Get available prizes
        $prizes = WheelPrize::where('is_active', true)->get();
        
        if ($prizes->isEmpty()) {
            return ['success' => false, 'message' => 'لا توجد جوائز متاحة حالياً'];
        }

        // Calculate weighted random selection
        $selectedPrize = $this->selectPrize($prizes);

        // Create spin record with security hash
        $securityHash = $this->generateSecurityHash($userId, $ipAddress, $userAgent);
        
        $spin = WheelSpin::create([
            'user_id' => $userId,
            'wheel_prize_id' => $selectedPrize->id,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'is_used' => false,
        ]);

        return [
            'success' => true,
            'prize' => $selectedPrize,
            'spin_id' => $spin->id,
            'security_hash' => $securityHash,
        ];
    }

    public function claimPrize($spinId, $securityHash, $userId)
    {
        $spin = WheelSpin::where('id', $spinId)
            ->where('user_id', $userId)
            ->where('is_used', false)
            ->first();

        if (!$spin) {
            return ['success' => false, 'message' => 'الجائزة غير صالحة أو مستخدمة مسبقاً'];
        }

        // Verify security hash
        if (!$this->verifySecurityHash($securityHash, $userId, $spin->ip_address, $spin->user_agent)) {
            return ['success' => false, 'message' => 'رمز الأمان غير صحيح'];
        }

        return DB::transaction(function () use ($spin) {
            $prize = $spin->prize;
            
            // Apply prize based on type
            switch ($prize->type) {
                case 'points':
                    $this->awardPoints($spin->user_id, $prize->value, 'wheel_prize');
                    break;
                case 'discount':
                    // Store discount in user session or create discount code
                    $this->createDiscountCode($spin->user_id, $prize->value);
                    break;
                case 'free_shipping':
                    $this->grantFreeShipping($spin->user_id);
                    break;
            }

            // Mark spin as used
            $spin->update(['is_used' => true]);

            return [
                'success' => true,
                'prize' => $prize,
                'message' => $this->getPrizeMessage($prize),
            ];
        });
    }

    private function selectPrize($prizes)
    {
        $totalProbability = $prizes->sum('probability');
        $random = mt_rand(1, $totalProbability);
        
        $currentProbability = 0;
        foreach ($prizes as $prize) {
            $currentProbability += $prize->probability;
            if ($random <= $currentProbability) {
                return $prize;
            }
        }
        
        return $prizes->first();
    }

    private function generateSecurityHash($userId, $ipAddress, $userAgent)
    {
        $data = $userId . $ipAddress . $userAgent . now()->format('Y-m-d');
        return Hash::make($data);
    }

    private function verifySecurityHash($hash, $userId, $ipAddress, $userAgent)
    {
        $data = $userId . $ipAddress . $userAgent . now()->format('Y-m-d');
        return Hash::check($data, $hash);
    }

    private function awardPoints($userId, $points, $type)
    {
        UserPoint::create([
            'user_id' => $userId,
            'points' => $points,
            'type' => $type,
            'description' => 'جائزة من عجلة الحظ',
        ]);
    }

    private function createDiscountCode($userId, $discountValue)
    {
        // Implementation for creating discount codes
        // This would integrate with your discount system
    }

    private function grantFreeShipping($userId)
    {
        // Implementation for granting free shipping
        // This would integrate with your shipping system
    }

    private function getPrizeMessage($prize)
    {
        return match($prize->type) {
            'points' => "مبروك! لقد حصلت على {$prize->value} نقطة",
            'discount' => "مبروك! لقد حصلت على خصم {$prize->value}%",
            'free_shipping' => "مبروك! لقد حصلت على شحن مجاني",
            'gift' => "مبروك! لقد حصلت على {$prize->name}",
            default => "مبروك! لقد حصلت على جائزة"
        };
    }

    public function getWheelStatistics()
    {
        return [
            'total_spins' => WheelSpin::count(),
            'used_spins' => WheelSpin::where('is_used', true)->count(),
            'available_prizes' => WheelPrize::where('is_active', true)->count(),
        ];
    }
}

<?php

namespace App\Helpers;

class TierHelper
{
    /**
     * Lấy danh sách các mức hạng
     */
    public static function getTiers()
    {
        return [
            ['name' => 'PHỔ THÔNG', 'amount' => 5000000, 'display_amount' => '5.000.000 💰'],
            ['name' => 'TIÊU THƯƠNG', 'amount' => 25000000, 'display_amount' => '25.000.000 💰'],
            ['name' => 'THƯƠNG GIA', 'amount' => 125000000, 'display_amount' => '125.000.000 💰'],
            ['name' => 'ĐẠI LÝ', 'amount' => 500000000, 'display_amount' => '500.000.000 💰'],
            ['name' => 'DOANH NGHIỆP', 'amount' => 1000000000, 'display_amount' => '1.000.000.000 💰'],
        ];
    }

    /**
     * Lấy mức hạng hiện tại và mức tiếp theo dựa trên số tiền đã nạp
     */
    public static function getCurrentAndNextTier($totalDeposited)
    {
        $tiers = self::getTiers();
        $currentTier = null;
        $nextTier = null;
        
        foreach ($tiers as $index => $tier) {
            if ($totalDeposited >= $tier['amount']) {
                $currentTier = $tier;
                if ($index < count($tiers) - 1) {
                    $nextTier = $tiers[$index + 1];
                }
            } else {
                if (!$currentTier) {
                    $nextTier = $tier;
                }
                break;
            }
        }
        
        return [
            'currentTier' => $currentTier,
            'nextTier' => $nextTier
        ];
    }

    /**
     * Tính số tiền cần nạp để nâng hạng
     */
    public static function getAmountNeededForNextTier($totalDeposited)
    {
        $tierInfo = self::getCurrentAndNextTier($totalDeposited);
        $nextTier = $tierInfo['nextTier'];
        
        if ($nextTier) {
            return $nextTier['amount'] - $totalDeposited;
        }
        
        return 0;
    }
}

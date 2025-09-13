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
            ['name' => 'PHỔ THÔNG', 'amount' => 100, 'display_amount' => '100$'],
            ['name' => 'TIÊU THƯƠNG', 'amount' => 200, 'display_amount' => '200$'],
            ['name' => 'THƯƠNG GIA', 'amount' => 500, 'display_amount' => '500$'],
            ['name' => 'ĐẠI LÝ', 'amount' => 2000, 'display_amount' => '2.000$'],
            ['name' => 'DOANH NGHIỆP', 'amount' => 5000, 'display_amount' => '5.000$'],
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

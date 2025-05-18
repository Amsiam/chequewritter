<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChequeWrite extends Model
{
    protected $fillable = [
        'cheque_id',
        'amount',
        'payee',
        'date',
        'user_id',
    ];

    public function cheque()
    {
        return $this->belongsTo(Cheque::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function bank()
    {
        return $this->hasOneThrough(Bank::class, Cheque::class, 'id', 'id', 'cheque_id', 'bank_id');
    }
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->where('payee', 'like', '%' . $search . '%')
                ->orWhere('amount', 'like', '%' . $search . '%');
        });
    }
    public function scopeFilterByBank($query, $bankId)
    {
        return $query->whereHas('cheque', function ($query) use ($bankId) {
            $query->where('bank_id', $bankId);
        });
    }
    public function scopeFilterByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
    public function scopeFilterByDate($query, $date)
    {
        return $query->whereDate('date', $date);
    }
    public function scopeFilterByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('date', [$startDate, $endDate]);
    }
    public function scopeFilterByStatus($query, $status)
    {
        return $query->where('status', $status);
    }
    public function scopeFilterByChequeNumber($query, $chequeNumber)
    {
        return $query->whereHas('cheque', function ($query) use ($chequeNumber) {
            $query->where('cheque_number', $chequeNumber);
        });
    }
}

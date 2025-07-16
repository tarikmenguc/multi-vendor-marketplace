<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }
/** Sadece vendor'lar ürün oluşturabilir */
public function create(User $user): bool
{
    return $user->hasRole('vendor');
}

/** Ürünü sadece kendi ürünüyse görebilir (opsiyonel) */
public function view(User $user, Product $product): bool
{
    return $user->id === $product->vendor_id;
}

/** Sadece sahibi olan vendor güncelleyebilir */
public function update(User $user, Product $product): bool
{
    return $user->id === $product->vendor_id;
}

/** Sadece sahibi olan vendor silebilir */
public function delete(User $user, Product $product): bool
{
    return $user->id === $product->vendor_id;
}

/** Geri yükleme (şimdilik kapalı) */
public function restore(User $user, Product $product): bool
{
    return false;
}

/** Kalıcı silme (şimdilik kapalı) */
public function forceDelete(User $user, Product $product): bool
{
    return false;
}
}

<?php
namespace Armincms\Sofre;   


trait Branching 
{ 
    public function branches()
    {
        return $this->hasMany(static::class, 'chain_id');
    }

    public function scopeChained($query)
    {
        return $this->branching('chained');
    }

    public function scopeIndependent($query)
    {
        return $this->branching('independent');
    }

    public function scopeBranch($query)
    {
        return $this->branching('branch');
    }

    public function scopeBranching($query, $branching)
    {
        return $query->whereIn('branching', (array) $branching);
    }
}

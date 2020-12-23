<?php
namespace Armincms\Sofre;   


trait Branching 
{  
    /**
     * Query the related Restaurant.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function branch()
    {
        return $this->belongsTo(static::class);
    }

    /**
     * Query the related Restaurant.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function restaurants()
    {
        return $this->hasMany(static::class, 'chain_id');
    }

    /**
     * Query where is Independent.
     * 
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder       
     */
    public function scopeIndependent($query)
    {
        return $this->branching('independent');
    }

    /**
     * Query where is chained.
     * 
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder   
     */
    public function scopeChains($query)
    {
        return $this->branching('chained');
    } 

    /**
     * Query where is branch.
     * 
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder   
     */
    public function scopeBranchs($query)
    {
        return $this->branching('branch');
    } 

    /**
     * Query where is not branch.
     * 
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder   
     */
    public function scopeWithoutBranchs($query)
    {
        return $this->withoutBranching('branch');
    }

    /**
     * Query via the given branch.
     * 
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder   
     */
    public function scopeBranching($query, $branching)
    {
        return $query->whereIn('branching', (array) $branching);
    }  

    /**
     * Query without the given branch.
     * 
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder   
     */
    public function scopeWithoutBranching($query, $branching)
    {
        return $query->whereNotIn('branching', (array) $branching);
    } 
}

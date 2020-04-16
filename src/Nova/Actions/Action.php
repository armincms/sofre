<?php

namespace Armincms\Sofre\Nova\Actions;

use Illuminate\Bus\Queueable;
use Laravel\Nova\Actions\Action as NovaAction;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Str; 
use Laravel\Nova\Nova;

class Action extends NovaAction
{
    use InteractsWithQueue, Queueable, SerializesModels;  
    
    /**
     * Get the humanize name of the action.
     *
     * @return string
     */
    public function humanize()
    {
        return Nova::humanize($this);
    }

    /**
     * Get the displayable name of the action.
     *
     * @return string
     */
    public function name()
    {
        return __($this->humanize());
    }

    /**
     * Get the URI key for the action.
     *
     * @return string
     */
    public function uriKey()
    {
        return Str::slug($this->humanize(), '-', null);
    }
}

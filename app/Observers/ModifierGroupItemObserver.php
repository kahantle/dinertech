<?php

namespace App\Observers;

use App\Models\ModifierGroupItem;
use App\Models\ModifierGroup;

class ModifierGroupItemObserver
{
    /**
     * Handle the modifier group item "created" event.
     *
     * @param  \App\ModifierGroupItem  $modifierGroupItem
     * @return void
     */
    public function created(ModifierGroupItem $modifierGroupItem)
    {
        $modifier_group_id = $modifierGroupItem->modifier_group_id;
        $ModifierGroupItem = ModifierGroupItem::where('modifier_group_id', $modifier_group_id)->count();

        ModifierGroup::where('modifier_group_id', $modifier_group_id)->update(['minimum' => $ModifierGroupItem, 'maximum' => $ModifierGroupItem]);
    }

    /**
     * Handle the modifier group item "updated" event.
     *
     * @param  \App\ModifierGroupItem  $modifierGroupItem
     * @return void
     */
    public function updated(ModifierGroupItem $modifierGroupItem)
    {
        //
    }

    /**
     * Handle the modifier group item "deleted" event.
     *
     * @param  \App\ModifierGroupItem  $modifierGroupItem
     * @return void
     */
    public function deleted(ModifierGroupItem $modifierGroupItem)
    {
        //
    }

    /**
     * Handle the modifier group item "restored" event.
     *
     * @param  \App\ModifierGroupItem  $modifierGroupItem
     * @return void
     */
    public function restored(ModifierGroupItem $modifierGroupItem)
    {
        //
    }

    /**
     * Handle the modifier group item "force deleted" event.
     *
     * @param  \App\ModifierGroupItem  $modifierGroupItem
     * @return void
     */
    public function forceDeleted(ModifierGroupItem $modifierGroupItem)
    {
        //
    }
}

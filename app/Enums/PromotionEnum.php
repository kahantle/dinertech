<?php

namespace App\Enums;

class PromotionEnum
{
    const ACTIVE = 'ACTIVE';
    const SUCCESS = 'success';
    const ALWAYSAVAILABLE = 'Always Available';
    const RESTRICTED = 'Restricted';
    const HIDDEN = 'Hidden';

    //Client Type
    const ANYCUSTOMER = 'Any Customer,New or Returning';
    const NEWCUSTOMER = 'Only New Customer';
    const RETURNCUSTOMER = 'Only Returning Customer';

    //Payment Type
    const ONE='1';
    const CASE = 'Cash';
    const CARD = 'Credit Card';

    //Order Type
    const ANY = 'Any Type';
    const PICKUP = 'Pickup Type';
    const PICKUPTIME = 'Pickup Time';
}

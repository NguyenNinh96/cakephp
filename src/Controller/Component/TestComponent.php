<?php
namespace App\Controller\Component;

use Cake\Controller\Component;

class TestComponent extends Component
{
    public function Sum($amount1, $amount2)
    {
        return $amount1 + $amount2;
    }
}
?>
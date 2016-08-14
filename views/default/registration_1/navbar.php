<?php

use backend\widgets\MyWizardMenu;
use backend\modules\seller\assets\AppAsset;

$ss = AppAsset::register($this);
?>
<!--<div id="MyWizard" class="wizard">
    <ul class="steps">
        <li data-target="#step1" class="active"><span class="badge badge-info">1</span><span class="chevron"></span>Step 1</li>
        <li data-target="#step2"><span class="badge">2</span><span class="chevron"></span>Step 2</li>
        <li data-target="#step3"><span class="badge">3</span><span class="chevron"></span>Step 3</li>
        <li data-target="#step4"><span class="badge">4</span><span class="chevron"></span>Step 4</li>
        <li data-target="#step5"><span class="badge">5</span>Step 5</li>
    </ul>
</div>-->



<div id="MyWizard" class="wizard">
<?= MyWizardMenu::widget(['step' => $event->step, 'wizard' => $event->sender]) ?>
</div>
<hr />

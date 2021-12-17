<?php

namespace PHPMaker2021\Dermateknonew;

// Table
$ijinbpom = Container("ijinbpom");
?>
<?php if ($ijinbpom->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_ijinbpommaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($ijinbpom->idpegawai->Visible) { // idpegawai ?>
        <tr id="r_idpegawai">
            <td class="<?= $ijinbpom->TableLeftColumnClass ?>"><?= $ijinbpom->idpegawai->caption() ?></td>
            <td <?= $ijinbpom->idpegawai->cellAttributes() ?>>
<span id="el_ijinbpom_idpegawai">
<span<?= $ijinbpom->idpegawai->viewAttributes() ?>>
<?= $ijinbpom->idpegawai->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($ijinbpom->idcustomer->Visible) { // idcustomer ?>
        <tr id="r_idcustomer">
            <td class="<?= $ijinbpom->TableLeftColumnClass ?>"><?= $ijinbpom->idcustomer->caption() ?></td>
            <td <?= $ijinbpom->idcustomer->cellAttributes() ?>>
<span id="el_ijinbpom_idcustomer">
<span<?= $ijinbpom->idcustomer->viewAttributes() ?>>
<?= $ijinbpom->idcustomer->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($ijinbpom->idbrand->Visible) { // idbrand ?>
        <tr id="r_idbrand">
            <td class="<?= $ijinbpom->TableLeftColumnClass ?>"><?= $ijinbpom->idbrand->caption() ?></td>
            <td <?= $ijinbpom->idbrand->cellAttributes() ?>>
<span id="el_ijinbpom_idbrand">
<span<?= $ijinbpom->idbrand->viewAttributes() ?>>
<?= $ijinbpom->idbrand->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($ijinbpom->status->Visible) { // status ?>
        <tr id="r_status">
            <td class="<?= $ijinbpom->TableLeftColumnClass ?>"><?= $ijinbpom->status->caption() ?></td>
            <td <?= $ijinbpom->status->cellAttributes() ?>>
<span id="el_ijinbpom_status">
<span<?= $ijinbpom->status->viewAttributes() ?>>
<?= $ijinbpom->status->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($ijinbpom->selesai->Visible) { // selesai ?>
        <tr id="r_selesai">
            <td class="<?= $ijinbpom->TableLeftColumnClass ?>"><?= $ijinbpom->selesai->caption() ?></td>
            <td <?= $ijinbpom->selesai->cellAttributes() ?>>
<span id="el_ijinbpom_selesai">
<span<?= $ijinbpom->selesai->viewAttributes() ?>>
<?= $ijinbpom->selesai->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>

<?php

namespace PHPMaker2021\Dermateknonew;

// Page object
$TitipmerkValidasiView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var ftitipmerk_validasiview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    ftitipmerk_validasiview = currentForm = new ew.Form("ftitipmerk_validasiview", "view");
    loadjs.done("ftitipmerk_validasiview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.titipmerk_validasi) ew.vars.tables.titipmerk_validasi = <?= JsonEncode(GetClientVar("tables", "titipmerk_validasi")) ?>;
</script>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="ftitipmerk_validasiview" id="ftitipmerk_validasiview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="titipmerk_validasi">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_titipmerk_validasi_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_titipmerk_validasi_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idm_titipmerk->Visible) { // idm_titipmerk ?>
    <tr id="r_idm_titipmerk">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_titipmerk_validasi_idm_titipmerk"><?= $Page->idm_titipmerk->caption() ?></span></td>
        <td data-name="idm_titipmerk" <?= $Page->idm_titipmerk->cellAttributes() ?>>
<span id="el_titipmerk_validasi_idm_titipmerk">
<span<?= $Page->idm_titipmerk->viewAttributes() ?>>
<?= $Page->idm_titipmerk->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->validator->Visible) { // validator ?>
    <tr id="r_validator">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_titipmerk_validasi_validator"><?= $Page->validator->caption() ?></span></td>
        <td data-name="validator" <?= $Page->validator->cellAttributes() ?>>
<span id="el_titipmerk_validasi_validator">
<span<?= $Page->validator->viewAttributes() ?>>
<?= $Page->validator->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tanggal->Visible) { // tanggal ?>
    <tr id="r_tanggal">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_titipmerk_validasi_tanggal"><?= $Page->tanggal->caption() ?></span></td>
        <td data-name="tanggal" <?= $Page->tanggal->cellAttributes() ?>>
<span id="el_titipmerk_validasi_tanggal">
<span<?= $Page->tanggal->viewAttributes() ?>>
<?= $Page->tanggal->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->valid->Visible) { // valid ?>
    <tr id="r_valid">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_titipmerk_validasi_valid"><?= $Page->valid->caption() ?></span></td>
        <td data-name="valid" <?= $Page->valid->cellAttributes() ?>>
<span id="el_titipmerk_validasi_valid">
<span<?= $Page->valid->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_valid_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->valid->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->valid->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_valid_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <tr id="r_created_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_titipmerk_validasi_created_at"><?= $Page->created_at->caption() ?></span></td>
        <td data-name="created_at" <?= $Page->created_at->cellAttributes() ?>>
<span id="el_titipmerk_validasi_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->created_by->Visible) { // created_by ?>
    <tr id="r_created_by">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_titipmerk_validasi_created_by"><?= $Page->created_by->caption() ?></span></td>
        <td data-name="created_by" <?= $Page->created_by->cellAttributes() ?>>
<span id="el_titipmerk_validasi_created_by">
<span<?= $Page->created_by->viewAttributes() ?>>
<?= $Page->created_by->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>

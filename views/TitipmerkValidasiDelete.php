<?php

namespace PHPMaker2021\Dermateknonew;

// Page object
$TitipmerkValidasiDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var ftitipmerk_validasidelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    ftitipmerk_validasidelete = currentForm = new ew.Form("ftitipmerk_validasidelete", "delete");
    loadjs.done("ftitipmerk_validasidelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.titipmerk_validasi) ew.vars.tables.titipmerk_validasi = <?= JsonEncode(GetClientVar("tables", "titipmerk_validasi")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="ftitipmerk_validasidelete" id="ftitipmerk_validasidelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="titipmerk_validasi">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
    <thead>
    <tr class="ew-table-header">
<?php if ($Page->id->Visible) { // id ?>
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_titipmerk_validasi_id" class="titipmerk_validasi_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->idm_titipmerk->Visible) { // idm_titipmerk ?>
        <th class="<?= $Page->idm_titipmerk->headerCellClass() ?>"><span id="elh_titipmerk_validasi_idm_titipmerk" class="titipmerk_validasi_idm_titipmerk"><?= $Page->idm_titipmerk->caption() ?></span></th>
<?php } ?>
<?php if ($Page->validator->Visible) { // validator ?>
        <th class="<?= $Page->validator->headerCellClass() ?>"><span id="elh_titipmerk_validasi_validator" class="titipmerk_validasi_validator"><?= $Page->validator->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tanggal->Visible) { // tanggal ?>
        <th class="<?= $Page->tanggal->headerCellClass() ?>"><span id="elh_titipmerk_validasi_tanggal" class="titipmerk_validasi_tanggal"><?= $Page->tanggal->caption() ?></span></th>
<?php } ?>
<?php if ($Page->valid->Visible) { // valid ?>
        <th class="<?= $Page->valid->headerCellClass() ?>"><span id="elh_titipmerk_validasi_valid" class="titipmerk_validasi_valid"><?= $Page->valid->caption() ?></span></th>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <th class="<?= $Page->created_at->headerCellClass() ?>"><span id="elh_titipmerk_validasi_created_at" class="titipmerk_validasi_created_at"><?= $Page->created_at->caption() ?></span></th>
<?php } ?>
<?php if ($Page->created_by->Visible) { // created_by ?>
        <th class="<?= $Page->created_by->headerCellClass() ?>"><span id="elh_titipmerk_validasi_created_by" class="titipmerk_validasi_created_by"><?= $Page->created_by->caption() ?></span></th>
<?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
$Page->RecordCount = 0;
$i = 0;
while (!$Page->Recordset->EOF) {
    $Page->RecordCount++;
    $Page->RowCount++;

    // Set row properties
    $Page->resetAttributes();
    $Page->RowType = ROWTYPE_VIEW; // View

    // Get the field contents
    $Page->loadRowValues($Page->Recordset);

    // Render row
    $Page->renderRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php if ($Page->id->Visible) { // id ?>
        <td <?= $Page->id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_titipmerk_validasi_id" class="titipmerk_validasi_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->idm_titipmerk->Visible) { // idm_titipmerk ?>
        <td <?= $Page->idm_titipmerk->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_titipmerk_validasi_idm_titipmerk" class="titipmerk_validasi_idm_titipmerk">
<span<?= $Page->idm_titipmerk->viewAttributes() ?>>
<?= $Page->idm_titipmerk->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->validator->Visible) { // validator ?>
        <td <?= $Page->validator->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_titipmerk_validasi_validator" class="titipmerk_validasi_validator">
<span<?= $Page->validator->viewAttributes() ?>>
<?= $Page->validator->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tanggal->Visible) { // tanggal ?>
        <td <?= $Page->tanggal->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_titipmerk_validasi_tanggal" class="titipmerk_validasi_tanggal">
<span<?= $Page->tanggal->viewAttributes() ?>>
<?= $Page->tanggal->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->valid->Visible) { // valid ?>
        <td <?= $Page->valid->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_titipmerk_validasi_valid" class="titipmerk_validasi_valid">
<span<?= $Page->valid->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_valid_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->valid->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->valid->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_valid_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <td <?= $Page->created_at->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_titipmerk_validasi_created_at" class="titipmerk_validasi_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->created_by->Visible) { // created_by ?>
        <td <?= $Page->created_by->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_titipmerk_validasi_created_by" class="titipmerk_validasi_created_by">
<span<?= $Page->created_by->viewAttributes() ?>>
<?= $Page->created_by->getViewValue() ?></span>
</span>
</td>
<?php } ?>
    </tr>
<?php
    $Page->Recordset->moveNext();
}
$Page->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>

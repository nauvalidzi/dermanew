<?php

namespace PHPMaker2021\Dermateknonew;

// Page object
$NpdDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fnpddelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fnpddelete = currentForm = new ew.Form("fnpddelete", "delete");
    loadjs.done("fnpddelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.npd) ew.vars.tables.npd = <?= JsonEncode(GetClientVar("tables", "npd")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fnpddelete" id="fnpddelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd">
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
<?php if ($Page->idpegawai->Visible) { // idpegawai ?>
        <th class="<?= $Page->idpegawai->headerCellClass() ?>"><span id="elh_npd_idpegawai" class="npd_idpegawai"><?= $Page->idpegawai->caption() ?></span></th>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
        <th class="<?= $Page->idcustomer->headerCellClass() ?>"><span id="elh_npd_idcustomer" class="npd_idcustomer"><?= $Page->idcustomer->caption() ?></span></th>
<?php } ?>
<?php if ($Page->kodeorder->Visible) { // kodeorder ?>
        <th class="<?= $Page->kodeorder->headerCellClass() ?>"><span id="elh_npd_kodeorder" class="npd_kodeorder"><?= $Page->kodeorder->caption() ?></span></th>
<?php } ?>
<?php if ($Page->idbrand->Visible) { // idbrand ?>
        <th class="<?= $Page->idbrand->headerCellClass() ?>"><span id="elh_npd_idbrand" class="npd_idbrand"><?= $Page->idbrand->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
        <th class="<?= $Page->nama->headerCellClass() ?>"><span id="elh_npd_nama" class="npd_nama"><?= $Page->nama->caption() ?></span></th>
<?php } ?>
<?php if ($Page->idproduct_acuan->Visible) { // idproduct_acuan ?>
        <th class="<?= $Page->idproduct_acuan->headerCellClass() ?>"><span id="elh_npd_idproduct_acuan" class="npd_idproduct_acuan"><?= $Page->idproduct_acuan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <th class="<?= $Page->status->headerCellClass() ?>"><span id="elh_npd_status" class="npd_status"><?= $Page->status->caption() ?></span></th>
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
<?php if ($Page->idpegawai->Visible) { // idpegawai ?>
        <td <?= $Page->idpegawai->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_idpegawai" class="npd_idpegawai">
<span<?= $Page->idpegawai->viewAttributes() ?>>
<?= $Page->idpegawai->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
        <td <?= $Page->idcustomer->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_idcustomer" class="npd_idcustomer">
<span<?= $Page->idcustomer->viewAttributes() ?>>
<?= $Page->idcustomer->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->kodeorder->Visible) { // kodeorder ?>
        <td <?= $Page->kodeorder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_kodeorder" class="npd_kodeorder">
<span<?= $Page->kodeorder->viewAttributes() ?>>
<?= $Page->kodeorder->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->idbrand->Visible) { // idbrand ?>
        <td <?= $Page->idbrand->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_idbrand" class="npd_idbrand">
<span<?= $Page->idbrand->viewAttributes() ?>>
<?= $Page->idbrand->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
        <td <?= $Page->nama->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_nama" class="npd_nama">
<span<?= $Page->nama->viewAttributes() ?>>
<?= $Page->nama->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->idproduct_acuan->Visible) { // idproduct_acuan ?>
        <td <?= $Page->idproduct_acuan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_idproduct_acuan" class="npd_idproduct_acuan">
<span<?= $Page->idproduct_acuan->viewAttributes() ?>>
<?= $Page->idproduct_acuan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <td <?= $Page->status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_status" class="npd_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
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

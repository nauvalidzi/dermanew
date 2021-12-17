<?php

namespace PHPMaker2021\Dermateknonew;

// Page object
$NpdExtendDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fnpd_extenddelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fnpd_extenddelete = currentForm = new ew.Form("fnpd_extenddelete", "delete");
    loadjs.done("fnpd_extenddelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.npd_extend) ew.vars.tables.npd_extend = <?= JsonEncode(GetClientVar("tables", "npd_extend")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fnpd_extenddelete" id="fnpd_extenddelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_extend">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_npd_extend_id" class="npd_extend_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->idnpd->Visible) { // idnpd ?>
        <th class="<?= $Page->idnpd->headerCellClass() ?>"><span id="elh_npd_extend_idnpd" class="npd_extend_idnpd"><?= $Page->idnpd->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tglbayar->Visible) { // tglbayar ?>
        <th class="<?= $Page->tglbayar->headerCellClass() ?>"><span id="elh_npd_extend_tglbayar" class="npd_extend_tglbayar"><?= $Page->tglbayar->caption() ?></span></th>
<?php } ?>
<?php if ($Page->buktipembayaran->Visible) { // buktipembayaran ?>
        <th class="<?= $Page->buktipembayaran->headerCellClass() ?>"><span id="elh_npd_extend_buktipembayaran" class="npd_extend_buktipembayaran"><?= $Page->buktipembayaran->caption() ?></span></th>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <th class="<?= $Page->created_at->headerCellClass() ?>"><span id="elh_npd_extend_created_at" class="npd_extend_created_at"><?= $Page->created_at->caption() ?></span></th>
<?php } ?>
<?php if ($Page->created_by->Visible) { // created_by ?>
        <th class="<?= $Page->created_by->headerCellClass() ?>"><span id="elh_npd_extend_created_by" class="npd_extend_created_by"><?= $Page->created_by->caption() ?></span></th>
<?php } ?>
<?php if ($Page->readonly->Visible) { // readonly ?>
        <th class="<?= $Page->readonly->headerCellClass() ?>"><span id="elh_npd_extend_readonly" class="npd_extend_readonly"><?= $Page->readonly->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_npd_extend_id" class="npd_extend_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->idnpd->Visible) { // idnpd ?>
        <td <?= $Page->idnpd->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_extend_idnpd" class="npd_extend_idnpd">
<span<?= $Page->idnpd->viewAttributes() ?>>
<?= $Page->idnpd->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tglbayar->Visible) { // tglbayar ?>
        <td <?= $Page->tglbayar->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_extend_tglbayar" class="npd_extend_tglbayar">
<span<?= $Page->tglbayar->viewAttributes() ?>>
<?= $Page->tglbayar->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->buktipembayaran->Visible) { // buktipembayaran ?>
        <td <?= $Page->buktipembayaran->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_extend_buktipembayaran" class="npd_extend_buktipembayaran">
<span<?= $Page->buktipembayaran->viewAttributes() ?>>
<?= $Page->buktipembayaran->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <td <?= $Page->created_at->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_extend_created_at" class="npd_extend_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->created_by->Visible) { // created_by ?>
        <td <?= $Page->created_by->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_extend_created_by" class="npd_extend_created_by">
<span<?= $Page->created_by->viewAttributes() ?>>
<?= $Page->created_by->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->readonly->Visible) { // readonly ?>
        <td <?= $Page->readonly->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_extend_readonly" class="npd_extend_readonly">
<span<?= $Page->readonly->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_readonly_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->readonly->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->readonly->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_readonly_<?= $Page->RowCount ?>"></label>
</div></span>
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

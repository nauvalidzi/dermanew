<?php

namespace PHPMaker2021\Dermateknonew;

// Page object
$NpdReviewDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fnpd_reviewdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fnpd_reviewdelete = currentForm = new ew.Form("fnpd_reviewdelete", "delete");
    loadjs.done("fnpd_reviewdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.npd_review) ew.vars.tables.npd_review = <?= JsonEncode(GetClientVar("tables", "npd_review")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fnpd_reviewdelete" id="fnpd_reviewdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_review">
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
<?php if ($Page->idnpd_sample->Visible) { // idnpd_sample ?>
        <th class="<?= $Page->idnpd_sample->headerCellClass() ?>"><span id="elh_npd_review_idnpd_sample" class="npd_review_idnpd_sample"><?= $Page->idnpd_sample->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tglreview->Visible) { // tglreview ?>
        <th class="<?= $Page->tglreview->headerCellClass() ?>"><span id="elh_npd_review_tglreview" class="npd_review_tglreview"><?= $Page->tglreview->caption() ?></span></th>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <th class="<?= $Page->status->headerCellClass() ?>"><span id="elh_npd_review_status" class="npd_review_status"><?= $Page->status->caption() ?></span></th>
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
<?php if ($Page->idnpd_sample->Visible) { // idnpd_sample ?>
        <td <?= $Page->idnpd_sample->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_review_idnpd_sample" class="npd_review_idnpd_sample">
<span<?= $Page->idnpd_sample->viewAttributes() ?>>
<?= $Page->idnpd_sample->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tglreview->Visible) { // tglreview ?>
        <td <?= $Page->tglreview->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_review_tglreview" class="npd_review_tglreview">
<span<?= $Page->tglreview->viewAttributes() ?>>
<?= $Page->tglreview->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <td <?= $Page->status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_review_status" class="npd_review_status">
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

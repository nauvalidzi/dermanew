<?php

namespace PHPMaker2021\Dermateknonew;

// Page object
$NpdTermsDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fnpd_termsdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fnpd_termsdelete = currentForm = new ew.Form("fnpd_termsdelete", "delete");
    loadjs.done("fnpd_termsdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.npd_terms) ew.vars.tables.npd_terms = <?= JsonEncode(GetClientVar("tables", "npd_terms")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fnpd_termsdelete" id="fnpd_termsdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_terms">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_npd_terms_id" class="npd_terms_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->idnpd->Visible) { // idnpd ?>
        <th class="<?= $Page->idnpd->headerCellClass() ?>"><span id="elh_npd_terms_idnpd" class="npd_terms_idnpd"><?= $Page->idnpd->caption() ?></span></th>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <th class="<?= $Page->status->headerCellClass() ?>"><span id="elh_npd_terms_status" class="npd_terms_status"><?= $Page->status->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tglsubmit->Visible) { // tglsubmit ?>
        <th class="<?= $Page->tglsubmit->headerCellClass() ?>"><span id="elh_npd_terms_tglsubmit" class="npd_terms_tglsubmit"><?= $Page->tglsubmit->caption() ?></span></th>
<?php } ?>
<?php if ($Page->sifatorder->Visible) { // sifatorder ?>
        <th class="<?= $Page->sifatorder->headerCellClass() ?>"><span id="elh_npd_terms_sifatorder" class="npd_terms_sifatorder"><?= $Page->sifatorder->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ukuranutama->Visible) { // ukuranutama ?>
        <th class="<?= $Page->ukuranutama->headerCellClass() ?>"><span id="elh_npd_terms_ukuranutama" class="npd_terms_ukuranutama"><?= $Page->ukuranutama->caption() ?></span></th>
<?php } ?>
<?php if ($Page->utamahargaisipcs->Visible) { // utamahargaisipcs ?>
        <th class="<?= $Page->utamahargaisipcs->headerCellClass() ?>"><span id="elh_npd_terms_utamahargaisipcs" class="npd_terms_utamahargaisipcs"><?= $Page->utamahargaisipcs->caption() ?></span></th>
<?php } ?>
<?php if ($Page->utamahargaprimerpcs->Visible) { // utamahargaprimerpcs ?>
        <th class="<?= $Page->utamahargaprimerpcs->headerCellClass() ?>"><span id="elh_npd_terms_utamahargaprimerpcs" class="npd_terms_utamahargaprimerpcs"><?= $Page->utamahargaprimerpcs->caption() ?></span></th>
<?php } ?>
<?php if ($Page->utamahargasekunderpcs->Visible) { // utamahargasekunderpcs ?>
        <th class="<?= $Page->utamahargasekunderpcs->headerCellClass() ?>"><span id="elh_npd_terms_utamahargasekunderpcs" class="npd_terms_utamahargasekunderpcs"><?= $Page->utamahargasekunderpcs->caption() ?></span></th>
<?php } ?>
<?php if ($Page->utamahargalabelpcs->Visible) { // utamahargalabelpcs ?>
        <th class="<?= $Page->utamahargalabelpcs->headerCellClass() ?>"><span id="elh_npd_terms_utamahargalabelpcs" class="npd_terms_utamahargalabelpcs"><?= $Page->utamahargalabelpcs->caption() ?></span></th>
<?php } ?>
<?php if ($Page->utamahargatotalpcs->Visible) { // utamahargatotalpcs ?>
        <th class="<?= $Page->utamahargatotalpcs->headerCellClass() ?>"><span id="elh_npd_terms_utamahargatotalpcs" class="npd_terms_utamahargatotalpcs"><?= $Page->utamahargatotalpcs->caption() ?></span></th>
<?php } ?>
<?php if ($Page->utamahargaisiorder->Visible) { // utamahargaisiorder ?>
        <th class="<?= $Page->utamahargaisiorder->headerCellClass() ?>"><span id="elh_npd_terms_utamahargaisiorder" class="npd_terms_utamahargaisiorder"><?= $Page->utamahargaisiorder->caption() ?></span></th>
<?php } ?>
<?php if ($Page->utamahargaprimerorder->Visible) { // utamahargaprimerorder ?>
        <th class="<?= $Page->utamahargaprimerorder->headerCellClass() ?>"><span id="elh_npd_terms_utamahargaprimerorder" class="npd_terms_utamahargaprimerorder"><?= $Page->utamahargaprimerorder->caption() ?></span></th>
<?php } ?>
<?php if ($Page->utamahargasekunderorder->Visible) { // utamahargasekunderorder ?>
        <th class="<?= $Page->utamahargasekunderorder->headerCellClass() ?>"><span id="elh_npd_terms_utamahargasekunderorder" class="npd_terms_utamahargasekunderorder"><?= $Page->utamahargasekunderorder->caption() ?></span></th>
<?php } ?>
<?php if ($Page->utamahargalabelorder->Visible) { // utamahargalabelorder ?>
        <th class="<?= $Page->utamahargalabelorder->headerCellClass() ?>"><span id="elh_npd_terms_utamahargalabelorder" class="npd_terms_utamahargalabelorder"><?= $Page->utamahargalabelorder->caption() ?></span></th>
<?php } ?>
<?php if ($Page->utamahargatotalorder->Visible) { // utamahargatotalorder ?>
        <th class="<?= $Page->utamahargatotalorder->headerCellClass() ?>"><span id="elh_npd_terms_utamahargatotalorder" class="npd_terms_utamahargatotalorder"><?= $Page->utamahargatotalorder->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ukuranlain->Visible) { // ukuranlain ?>
        <th class="<?= $Page->ukuranlain->headerCellClass() ?>"><span id="elh_npd_terms_ukuranlain" class="npd_terms_ukuranlain"><?= $Page->ukuranlain->caption() ?></span></th>
<?php } ?>
<?php if ($Page->lainhargaisipcs->Visible) { // lainhargaisipcs ?>
        <th class="<?= $Page->lainhargaisipcs->headerCellClass() ?>"><span id="elh_npd_terms_lainhargaisipcs" class="npd_terms_lainhargaisipcs"><?= $Page->lainhargaisipcs->caption() ?></span></th>
<?php } ?>
<?php if ($Page->lainhargaprimerpcs->Visible) { // lainhargaprimerpcs ?>
        <th class="<?= $Page->lainhargaprimerpcs->headerCellClass() ?>"><span id="elh_npd_terms_lainhargaprimerpcs" class="npd_terms_lainhargaprimerpcs"><?= $Page->lainhargaprimerpcs->caption() ?></span></th>
<?php } ?>
<?php if ($Page->lainhargasekunderpcs->Visible) { // lainhargasekunderpcs ?>
        <th class="<?= $Page->lainhargasekunderpcs->headerCellClass() ?>"><span id="elh_npd_terms_lainhargasekunderpcs" class="npd_terms_lainhargasekunderpcs"><?= $Page->lainhargasekunderpcs->caption() ?></span></th>
<?php } ?>
<?php if ($Page->lainhargalabelpcs->Visible) { // lainhargalabelpcs ?>
        <th class="<?= $Page->lainhargalabelpcs->headerCellClass() ?>"><span id="elh_npd_terms_lainhargalabelpcs" class="npd_terms_lainhargalabelpcs"><?= $Page->lainhargalabelpcs->caption() ?></span></th>
<?php } ?>
<?php if ($Page->lainhargatotalpcs->Visible) { // lainhargatotalpcs ?>
        <th class="<?= $Page->lainhargatotalpcs->headerCellClass() ?>"><span id="elh_npd_terms_lainhargatotalpcs" class="npd_terms_lainhargatotalpcs"><?= $Page->lainhargatotalpcs->caption() ?></span></th>
<?php } ?>
<?php if ($Page->lainhargaisiorder->Visible) { // lainhargaisiorder ?>
        <th class="<?= $Page->lainhargaisiorder->headerCellClass() ?>"><span id="elh_npd_terms_lainhargaisiorder" class="npd_terms_lainhargaisiorder"><?= $Page->lainhargaisiorder->caption() ?></span></th>
<?php } ?>
<?php if ($Page->lainhargaprimerorder->Visible) { // lainhargaprimerorder ?>
        <th class="<?= $Page->lainhargaprimerorder->headerCellClass() ?>"><span id="elh_npd_terms_lainhargaprimerorder" class="npd_terms_lainhargaprimerorder"><?= $Page->lainhargaprimerorder->caption() ?></span></th>
<?php } ?>
<?php if ($Page->lainhargasekunderorder->Visible) { // lainhargasekunderorder ?>
        <th class="<?= $Page->lainhargasekunderorder->headerCellClass() ?>"><span id="elh_npd_terms_lainhargasekunderorder" class="npd_terms_lainhargasekunderorder"><?= $Page->lainhargasekunderorder->caption() ?></span></th>
<?php } ?>
<?php if ($Page->lainhargalabelorder->Visible) { // lainhargalabelorder ?>
        <th class="<?= $Page->lainhargalabelorder->headerCellClass() ?>"><span id="elh_npd_terms_lainhargalabelorder" class="npd_terms_lainhargalabelorder"><?= $Page->lainhargalabelorder->caption() ?></span></th>
<?php } ?>
<?php if ($Page->lainhargatotalorder->Visible) { // lainhargatotalorder ?>
        <th class="<?= $Page->lainhargatotalorder->headerCellClass() ?>"><span id="elh_npd_terms_lainhargatotalorder" class="npd_terms_lainhargatotalorder"><?= $Page->lainhargatotalorder->caption() ?></span></th>
<?php } ?>
<?php if ($Page->isibahanaktif->Visible) { // isibahanaktif ?>
        <th class="<?= $Page->isibahanaktif->headerCellClass() ?>"><span id="elh_npd_terms_isibahanaktif" class="npd_terms_isibahanaktif"><?= $Page->isibahanaktif->caption() ?></span></th>
<?php } ?>
<?php if ($Page->isibahanlain->Visible) { // isibahanlain ?>
        <th class="<?= $Page->isibahanlain->headerCellClass() ?>"><span id="elh_npd_terms_isibahanlain" class="npd_terms_isibahanlain"><?= $Page->isibahanlain->caption() ?></span></th>
<?php } ?>
<?php if ($Page->isiparfum->Visible) { // isiparfum ?>
        <th class="<?= $Page->isiparfum->headerCellClass() ?>"><span id="elh_npd_terms_isiparfum" class="npd_terms_isiparfum"><?= $Page->isiparfum->caption() ?></span></th>
<?php } ?>
<?php if ($Page->isiestetika->Visible) { // isiestetika ?>
        <th class="<?= $Page->isiestetika->headerCellClass() ?>"><span id="elh_npd_terms_isiestetika" class="npd_terms_isiestetika"><?= $Page->isiestetika->caption() ?></span></th>
<?php } ?>
<?php if ($Page->kemasanwadah->Visible) { // kemasanwadah ?>
        <th class="<?= $Page->kemasanwadah->headerCellClass() ?>"><span id="elh_npd_terms_kemasanwadah" class="npd_terms_kemasanwadah"><?= $Page->kemasanwadah->caption() ?></span></th>
<?php } ?>
<?php if ($Page->kemasantutup->Visible) { // kemasantutup ?>
        <th class="<?= $Page->kemasantutup->headerCellClass() ?>"><span id="elh_npd_terms_kemasantutup" class="npd_terms_kemasantutup"><?= $Page->kemasantutup->caption() ?></span></th>
<?php } ?>
<?php if ($Page->kemasansekunder->Visible) { // kemasansekunder ?>
        <th class="<?= $Page->kemasansekunder->headerCellClass() ?>"><span id="elh_npd_terms_kemasansekunder" class="npd_terms_kemasansekunder"><?= $Page->kemasansekunder->caption() ?></span></th>
<?php } ?>
<?php if ($Page->desainlabel->Visible) { // desainlabel ?>
        <th class="<?= $Page->desainlabel->headerCellClass() ?>"><span id="elh_npd_terms_desainlabel" class="npd_terms_desainlabel"><?= $Page->desainlabel->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cetaklabel->Visible) { // cetaklabel ?>
        <th class="<?= $Page->cetaklabel->headerCellClass() ?>"><span id="elh_npd_terms_cetaklabel" class="npd_terms_cetaklabel"><?= $Page->cetaklabel->caption() ?></span></th>
<?php } ?>
<?php if ($Page->lainlain->Visible) { // lainlain ?>
        <th class="<?= $Page->lainlain->headerCellClass() ?>"><span id="elh_npd_terms_lainlain" class="npd_terms_lainlain"><?= $Page->lainlain->caption() ?></span></th>
<?php } ?>
<?php if ($Page->deliverypickup->Visible) { // deliverypickup ?>
        <th class="<?= $Page->deliverypickup->headerCellClass() ?>"><span id="elh_npd_terms_deliverypickup" class="npd_terms_deliverypickup"><?= $Page->deliverypickup->caption() ?></span></th>
<?php } ?>
<?php if ($Page->deliverysinglepoint->Visible) { // deliverysinglepoint ?>
        <th class="<?= $Page->deliverysinglepoint->headerCellClass() ?>"><span id="elh_npd_terms_deliverysinglepoint" class="npd_terms_deliverysinglepoint"><?= $Page->deliverysinglepoint->caption() ?></span></th>
<?php } ?>
<?php if ($Page->deliverymultipoint->Visible) { // deliverymultipoint ?>
        <th class="<?= $Page->deliverymultipoint->headerCellClass() ?>"><span id="elh_npd_terms_deliverymultipoint" class="npd_terms_deliverymultipoint"><?= $Page->deliverymultipoint->caption() ?></span></th>
<?php } ?>
<?php if ($Page->deliveryjumlahpoint->Visible) { // deliveryjumlahpoint ?>
        <th class="<?= $Page->deliveryjumlahpoint->headerCellClass() ?>"><span id="elh_npd_terms_deliveryjumlahpoint" class="npd_terms_deliveryjumlahpoint"><?= $Page->deliveryjumlahpoint->caption() ?></span></th>
<?php } ?>
<?php if ($Page->deliverytermslain->Visible) { // deliverytermslain ?>
        <th class="<?= $Page->deliverytermslain->headerCellClass() ?>"><span id="elh_npd_terms_deliverytermslain" class="npd_terms_deliverytermslain"><?= $Page->deliverytermslain->caption() ?></span></th>
<?php } ?>
<?php if ($Page->catatankhusus->Visible) { // catatankhusus ?>
        <th class="<?= $Page->catatankhusus->headerCellClass() ?>"><span id="elh_npd_terms_catatankhusus" class="npd_terms_catatankhusus"><?= $Page->catatankhusus->caption() ?></span></th>
<?php } ?>
<?php if ($Page->dibuatdi->Visible) { // dibuatdi ?>
        <th class="<?= $Page->dibuatdi->headerCellClass() ?>"><span id="elh_npd_terms_dibuatdi" class="npd_terms_dibuatdi"><?= $Page->dibuatdi->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tanggal->Visible) { // tanggal ?>
        <th class="<?= $Page->tanggal->headerCellClass() ?>"><span id="elh_npd_terms_tanggal" class="npd_terms_tanggal"><?= $Page->tanggal->caption() ?></span></th>
<?php } ?>
<?php if ($Page->created_by->Visible) { // created_by ?>
        <th class="<?= $Page->created_by->headerCellClass() ?>"><span id="elh_npd_terms_created_by" class="npd_terms_created_by"><?= $Page->created_by->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_npd_terms_id" class="npd_terms_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->idnpd->Visible) { // idnpd ?>
        <td <?= $Page->idnpd->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_idnpd" class="npd_terms_idnpd">
<span<?= $Page->idnpd->viewAttributes() ?>>
<?= $Page->idnpd->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <td <?= $Page->status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_status" class="npd_terms_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tglsubmit->Visible) { // tglsubmit ?>
        <td <?= $Page->tglsubmit->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_tglsubmit" class="npd_terms_tglsubmit">
<span<?= $Page->tglsubmit->viewAttributes() ?>>
<?= $Page->tglsubmit->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->sifatorder->Visible) { // sifatorder ?>
        <td <?= $Page->sifatorder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_sifatorder" class="npd_terms_sifatorder">
<span<?= $Page->sifatorder->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_sifatorder_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->sifatorder->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->sifatorder->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_sifatorder_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ukuranutama->Visible) { // ukuranutama ?>
        <td <?= $Page->ukuranutama->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_ukuranutama" class="npd_terms_ukuranutama">
<span<?= $Page->ukuranutama->viewAttributes() ?>>
<?= $Page->ukuranutama->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->utamahargaisipcs->Visible) { // utamahargaisipcs ?>
        <td <?= $Page->utamahargaisipcs->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_utamahargaisipcs" class="npd_terms_utamahargaisipcs">
<span<?= $Page->utamahargaisipcs->viewAttributes() ?>>
<?= $Page->utamahargaisipcs->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->utamahargaprimerpcs->Visible) { // utamahargaprimerpcs ?>
        <td <?= $Page->utamahargaprimerpcs->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_utamahargaprimerpcs" class="npd_terms_utamahargaprimerpcs">
<span<?= $Page->utamahargaprimerpcs->viewAttributes() ?>>
<?= $Page->utamahargaprimerpcs->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->utamahargasekunderpcs->Visible) { // utamahargasekunderpcs ?>
        <td <?= $Page->utamahargasekunderpcs->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_utamahargasekunderpcs" class="npd_terms_utamahargasekunderpcs">
<span<?= $Page->utamahargasekunderpcs->viewAttributes() ?>>
<?= $Page->utamahargasekunderpcs->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->utamahargalabelpcs->Visible) { // utamahargalabelpcs ?>
        <td <?= $Page->utamahargalabelpcs->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_utamahargalabelpcs" class="npd_terms_utamahargalabelpcs">
<span<?= $Page->utamahargalabelpcs->viewAttributes() ?>>
<?= $Page->utamahargalabelpcs->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->utamahargatotalpcs->Visible) { // utamahargatotalpcs ?>
        <td <?= $Page->utamahargatotalpcs->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_utamahargatotalpcs" class="npd_terms_utamahargatotalpcs">
<span<?= $Page->utamahargatotalpcs->viewAttributes() ?>>
<?= $Page->utamahargatotalpcs->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->utamahargaisiorder->Visible) { // utamahargaisiorder ?>
        <td <?= $Page->utamahargaisiorder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_utamahargaisiorder" class="npd_terms_utamahargaisiorder">
<span<?= $Page->utamahargaisiorder->viewAttributes() ?>>
<?= $Page->utamahargaisiorder->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->utamahargaprimerorder->Visible) { // utamahargaprimerorder ?>
        <td <?= $Page->utamahargaprimerorder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_utamahargaprimerorder" class="npd_terms_utamahargaprimerorder">
<span<?= $Page->utamahargaprimerorder->viewAttributes() ?>>
<?= $Page->utamahargaprimerorder->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->utamahargasekunderorder->Visible) { // utamahargasekunderorder ?>
        <td <?= $Page->utamahargasekunderorder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_utamahargasekunderorder" class="npd_terms_utamahargasekunderorder">
<span<?= $Page->utamahargasekunderorder->viewAttributes() ?>>
<?= $Page->utamahargasekunderorder->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->utamahargalabelorder->Visible) { // utamahargalabelorder ?>
        <td <?= $Page->utamahargalabelorder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_utamahargalabelorder" class="npd_terms_utamahargalabelorder">
<span<?= $Page->utamahargalabelorder->viewAttributes() ?>>
<?= $Page->utamahargalabelorder->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->utamahargatotalorder->Visible) { // utamahargatotalorder ?>
        <td <?= $Page->utamahargatotalorder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_utamahargatotalorder" class="npd_terms_utamahargatotalorder">
<span<?= $Page->utamahargatotalorder->viewAttributes() ?>>
<?= $Page->utamahargatotalorder->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ukuranlain->Visible) { // ukuranlain ?>
        <td <?= $Page->ukuranlain->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_ukuranlain" class="npd_terms_ukuranlain">
<span<?= $Page->ukuranlain->viewAttributes() ?>>
<?= $Page->ukuranlain->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->lainhargaisipcs->Visible) { // lainhargaisipcs ?>
        <td <?= $Page->lainhargaisipcs->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_lainhargaisipcs" class="npd_terms_lainhargaisipcs">
<span<?= $Page->lainhargaisipcs->viewAttributes() ?>>
<?= $Page->lainhargaisipcs->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->lainhargaprimerpcs->Visible) { // lainhargaprimerpcs ?>
        <td <?= $Page->lainhargaprimerpcs->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_lainhargaprimerpcs" class="npd_terms_lainhargaprimerpcs">
<span<?= $Page->lainhargaprimerpcs->viewAttributes() ?>>
<?= $Page->lainhargaprimerpcs->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->lainhargasekunderpcs->Visible) { // lainhargasekunderpcs ?>
        <td <?= $Page->lainhargasekunderpcs->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_lainhargasekunderpcs" class="npd_terms_lainhargasekunderpcs">
<span<?= $Page->lainhargasekunderpcs->viewAttributes() ?>>
<?= $Page->lainhargasekunderpcs->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->lainhargalabelpcs->Visible) { // lainhargalabelpcs ?>
        <td <?= $Page->lainhargalabelpcs->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_lainhargalabelpcs" class="npd_terms_lainhargalabelpcs">
<span<?= $Page->lainhargalabelpcs->viewAttributes() ?>>
<?= $Page->lainhargalabelpcs->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->lainhargatotalpcs->Visible) { // lainhargatotalpcs ?>
        <td <?= $Page->lainhargatotalpcs->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_lainhargatotalpcs" class="npd_terms_lainhargatotalpcs">
<span<?= $Page->lainhargatotalpcs->viewAttributes() ?>>
<?= $Page->lainhargatotalpcs->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->lainhargaisiorder->Visible) { // lainhargaisiorder ?>
        <td <?= $Page->lainhargaisiorder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_lainhargaisiorder" class="npd_terms_lainhargaisiorder">
<span<?= $Page->lainhargaisiorder->viewAttributes() ?>>
<?= $Page->lainhargaisiorder->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->lainhargaprimerorder->Visible) { // lainhargaprimerorder ?>
        <td <?= $Page->lainhargaprimerorder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_lainhargaprimerorder" class="npd_terms_lainhargaprimerorder">
<span<?= $Page->lainhargaprimerorder->viewAttributes() ?>>
<?= $Page->lainhargaprimerorder->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->lainhargasekunderorder->Visible) { // lainhargasekunderorder ?>
        <td <?= $Page->lainhargasekunderorder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_lainhargasekunderorder" class="npd_terms_lainhargasekunderorder">
<span<?= $Page->lainhargasekunderorder->viewAttributes() ?>>
<?= $Page->lainhargasekunderorder->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->lainhargalabelorder->Visible) { // lainhargalabelorder ?>
        <td <?= $Page->lainhargalabelorder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_lainhargalabelorder" class="npd_terms_lainhargalabelorder">
<span<?= $Page->lainhargalabelorder->viewAttributes() ?>>
<?= $Page->lainhargalabelorder->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->lainhargatotalorder->Visible) { // lainhargatotalorder ?>
        <td <?= $Page->lainhargatotalorder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_lainhargatotalorder" class="npd_terms_lainhargatotalorder">
<span<?= $Page->lainhargatotalorder->viewAttributes() ?>>
<?= $Page->lainhargatotalorder->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->isibahanaktif->Visible) { // isibahanaktif ?>
        <td <?= $Page->isibahanaktif->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_isibahanaktif" class="npd_terms_isibahanaktif">
<span<?= $Page->isibahanaktif->viewAttributes() ?>>
<?= $Page->isibahanaktif->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->isibahanlain->Visible) { // isibahanlain ?>
        <td <?= $Page->isibahanlain->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_isibahanlain" class="npd_terms_isibahanlain">
<span<?= $Page->isibahanlain->viewAttributes() ?>>
<?= $Page->isibahanlain->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->isiparfum->Visible) { // isiparfum ?>
        <td <?= $Page->isiparfum->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_isiparfum" class="npd_terms_isiparfum">
<span<?= $Page->isiparfum->viewAttributes() ?>>
<?= $Page->isiparfum->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->isiestetika->Visible) { // isiestetika ?>
        <td <?= $Page->isiestetika->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_isiestetika" class="npd_terms_isiestetika">
<span<?= $Page->isiestetika->viewAttributes() ?>>
<?= $Page->isiestetika->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->kemasanwadah->Visible) { // kemasanwadah ?>
        <td <?= $Page->kemasanwadah->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_kemasanwadah" class="npd_terms_kemasanwadah">
<span<?= $Page->kemasanwadah->viewAttributes() ?>>
<?= $Page->kemasanwadah->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->kemasantutup->Visible) { // kemasantutup ?>
        <td <?= $Page->kemasantutup->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_kemasantutup" class="npd_terms_kemasantutup">
<span<?= $Page->kemasantutup->viewAttributes() ?>>
<?= $Page->kemasantutup->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->kemasansekunder->Visible) { // kemasansekunder ?>
        <td <?= $Page->kemasansekunder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_kemasansekunder" class="npd_terms_kemasansekunder">
<span<?= $Page->kemasansekunder->viewAttributes() ?>>
<?= $Page->kemasansekunder->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->desainlabel->Visible) { // desainlabel ?>
        <td <?= $Page->desainlabel->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_desainlabel" class="npd_terms_desainlabel">
<span<?= $Page->desainlabel->viewAttributes() ?>>
<?= $Page->desainlabel->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cetaklabel->Visible) { // cetaklabel ?>
        <td <?= $Page->cetaklabel->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_cetaklabel" class="npd_terms_cetaklabel">
<span<?= $Page->cetaklabel->viewAttributes() ?>>
<?= $Page->cetaklabel->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->lainlain->Visible) { // lainlain ?>
        <td <?= $Page->lainlain->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_lainlain" class="npd_terms_lainlain">
<span<?= $Page->lainlain->viewAttributes() ?>>
<?= $Page->lainlain->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->deliverypickup->Visible) { // deliverypickup ?>
        <td <?= $Page->deliverypickup->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_deliverypickup" class="npd_terms_deliverypickup">
<span<?= $Page->deliverypickup->viewAttributes() ?>>
<?= $Page->deliverypickup->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->deliverysinglepoint->Visible) { // deliverysinglepoint ?>
        <td <?= $Page->deliverysinglepoint->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_deliverysinglepoint" class="npd_terms_deliverysinglepoint">
<span<?= $Page->deliverysinglepoint->viewAttributes() ?>>
<?= $Page->deliverysinglepoint->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->deliverymultipoint->Visible) { // deliverymultipoint ?>
        <td <?= $Page->deliverymultipoint->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_deliverymultipoint" class="npd_terms_deliverymultipoint">
<span<?= $Page->deliverymultipoint->viewAttributes() ?>>
<?= $Page->deliverymultipoint->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->deliveryjumlahpoint->Visible) { // deliveryjumlahpoint ?>
        <td <?= $Page->deliveryjumlahpoint->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_deliveryjumlahpoint" class="npd_terms_deliveryjumlahpoint">
<span<?= $Page->deliveryjumlahpoint->viewAttributes() ?>>
<?= $Page->deliveryjumlahpoint->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->deliverytermslain->Visible) { // deliverytermslain ?>
        <td <?= $Page->deliverytermslain->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_deliverytermslain" class="npd_terms_deliverytermslain">
<span<?= $Page->deliverytermslain->viewAttributes() ?>>
<?= $Page->deliverytermslain->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->catatankhusus->Visible) { // catatankhusus ?>
        <td <?= $Page->catatankhusus->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_catatankhusus" class="npd_terms_catatankhusus">
<span<?= $Page->catatankhusus->viewAttributes() ?>>
<?= $Page->catatankhusus->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->dibuatdi->Visible) { // dibuatdi ?>
        <td <?= $Page->dibuatdi->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_dibuatdi" class="npd_terms_dibuatdi">
<span<?= $Page->dibuatdi->viewAttributes() ?>>
<?= $Page->dibuatdi->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tanggal->Visible) { // tanggal ?>
        <td <?= $Page->tanggal->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_tanggal" class="npd_terms_tanggal">
<span<?= $Page->tanggal->viewAttributes() ?>>
<?= $Page->tanggal->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->created_by->Visible) { // created_by ?>
        <td <?= $Page->created_by->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_created_by" class="npd_terms_created_by">
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

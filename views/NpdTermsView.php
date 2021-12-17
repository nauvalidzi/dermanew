<?php

namespace PHPMaker2021\Dermateknonew;

// Page object
$NpdTermsView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fnpd_termsview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fnpd_termsview = currentForm = new ew.Form("fnpd_termsview", "view");
    loadjs.done("fnpd_termsview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.npd_terms) ew.vars.tables.npd_terms = <?= JsonEncode(GetClientVar("tables", "npd_terms")) ?>;
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
<form name="fnpd_termsview" id="fnpd_termsview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_terms">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_npd_terms_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idnpd->Visible) { // idnpd ?>
    <tr id="r_idnpd">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_idnpd"><?= $Page->idnpd->caption() ?></span></td>
        <td data-name="idnpd" <?= $Page->idnpd->cellAttributes() ?>>
<span id="el_npd_terms_idnpd">
<span<?= $Page->idnpd->viewAttributes() ?>>
<?= $Page->idnpd->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <tr id="r_status">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_status"><?= $Page->status->caption() ?></span></td>
        <td data-name="status" <?= $Page->status->cellAttributes() ?>>
<span id="el_npd_terms_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tglsubmit->Visible) { // tglsubmit ?>
    <tr id="r_tglsubmit">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_tglsubmit"><?= $Page->tglsubmit->caption() ?></span></td>
        <td data-name="tglsubmit" <?= $Page->tglsubmit->cellAttributes() ?>>
<span id="el_npd_terms_tglsubmit">
<span<?= $Page->tglsubmit->viewAttributes() ?>>
<?= $Page->tglsubmit->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->sifatorder->Visible) { // sifatorder ?>
    <tr id="r_sifatorder">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_sifatorder"><?= $Page->sifatorder->caption() ?></span></td>
        <td data-name="sifatorder" <?= $Page->sifatorder->cellAttributes() ?>>
<span id="el_npd_terms_sifatorder">
<span<?= $Page->sifatorder->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_sifatorder_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->sifatorder->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->sifatorder->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_sifatorder_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ukuranutama->Visible) { // ukuranutama ?>
    <tr id="r_ukuranutama">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_ukuranutama"><?= $Page->ukuranutama->caption() ?></span></td>
        <td data-name="ukuranutama" <?= $Page->ukuranutama->cellAttributes() ?>>
<span id="el_npd_terms_ukuranutama">
<span<?= $Page->ukuranutama->viewAttributes() ?>>
<?= $Page->ukuranutama->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->utamahargaisipcs->Visible) { // utamahargaisipcs ?>
    <tr id="r_utamahargaisipcs">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_utamahargaisipcs"><?= $Page->utamahargaisipcs->caption() ?></span></td>
        <td data-name="utamahargaisipcs" <?= $Page->utamahargaisipcs->cellAttributes() ?>>
<span id="el_npd_terms_utamahargaisipcs">
<span<?= $Page->utamahargaisipcs->viewAttributes() ?>>
<?= $Page->utamahargaisipcs->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->utamahargaprimerpcs->Visible) { // utamahargaprimerpcs ?>
    <tr id="r_utamahargaprimerpcs">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_utamahargaprimerpcs"><?= $Page->utamahargaprimerpcs->caption() ?></span></td>
        <td data-name="utamahargaprimerpcs" <?= $Page->utamahargaprimerpcs->cellAttributes() ?>>
<span id="el_npd_terms_utamahargaprimerpcs">
<span<?= $Page->utamahargaprimerpcs->viewAttributes() ?>>
<?= $Page->utamahargaprimerpcs->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->utamahargasekunderpcs->Visible) { // utamahargasekunderpcs ?>
    <tr id="r_utamahargasekunderpcs">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_utamahargasekunderpcs"><?= $Page->utamahargasekunderpcs->caption() ?></span></td>
        <td data-name="utamahargasekunderpcs" <?= $Page->utamahargasekunderpcs->cellAttributes() ?>>
<span id="el_npd_terms_utamahargasekunderpcs">
<span<?= $Page->utamahargasekunderpcs->viewAttributes() ?>>
<?= $Page->utamahargasekunderpcs->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->utamahargalabelpcs->Visible) { // utamahargalabelpcs ?>
    <tr id="r_utamahargalabelpcs">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_utamahargalabelpcs"><?= $Page->utamahargalabelpcs->caption() ?></span></td>
        <td data-name="utamahargalabelpcs" <?= $Page->utamahargalabelpcs->cellAttributes() ?>>
<span id="el_npd_terms_utamahargalabelpcs">
<span<?= $Page->utamahargalabelpcs->viewAttributes() ?>>
<?= $Page->utamahargalabelpcs->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->utamahargatotalpcs->Visible) { // utamahargatotalpcs ?>
    <tr id="r_utamahargatotalpcs">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_utamahargatotalpcs"><?= $Page->utamahargatotalpcs->caption() ?></span></td>
        <td data-name="utamahargatotalpcs" <?= $Page->utamahargatotalpcs->cellAttributes() ?>>
<span id="el_npd_terms_utamahargatotalpcs">
<span<?= $Page->utamahargatotalpcs->viewAttributes() ?>>
<?= $Page->utamahargatotalpcs->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->utamahargaisiorder->Visible) { // utamahargaisiorder ?>
    <tr id="r_utamahargaisiorder">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_utamahargaisiorder"><?= $Page->utamahargaisiorder->caption() ?></span></td>
        <td data-name="utamahargaisiorder" <?= $Page->utamahargaisiorder->cellAttributes() ?>>
<span id="el_npd_terms_utamahargaisiorder">
<span<?= $Page->utamahargaisiorder->viewAttributes() ?>>
<?= $Page->utamahargaisiorder->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->utamahargaprimerorder->Visible) { // utamahargaprimerorder ?>
    <tr id="r_utamahargaprimerorder">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_utamahargaprimerorder"><?= $Page->utamahargaprimerorder->caption() ?></span></td>
        <td data-name="utamahargaprimerorder" <?= $Page->utamahargaprimerorder->cellAttributes() ?>>
<span id="el_npd_terms_utamahargaprimerorder">
<span<?= $Page->utamahargaprimerorder->viewAttributes() ?>>
<?= $Page->utamahargaprimerorder->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->utamahargasekunderorder->Visible) { // utamahargasekunderorder ?>
    <tr id="r_utamahargasekunderorder">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_utamahargasekunderorder"><?= $Page->utamahargasekunderorder->caption() ?></span></td>
        <td data-name="utamahargasekunderorder" <?= $Page->utamahargasekunderorder->cellAttributes() ?>>
<span id="el_npd_terms_utamahargasekunderorder">
<span<?= $Page->utamahargasekunderorder->viewAttributes() ?>>
<?= $Page->utamahargasekunderorder->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->utamahargalabelorder->Visible) { // utamahargalabelorder ?>
    <tr id="r_utamahargalabelorder">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_utamahargalabelorder"><?= $Page->utamahargalabelorder->caption() ?></span></td>
        <td data-name="utamahargalabelorder" <?= $Page->utamahargalabelorder->cellAttributes() ?>>
<span id="el_npd_terms_utamahargalabelorder">
<span<?= $Page->utamahargalabelorder->viewAttributes() ?>>
<?= $Page->utamahargalabelorder->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->utamahargatotalorder->Visible) { // utamahargatotalorder ?>
    <tr id="r_utamahargatotalorder">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_utamahargatotalorder"><?= $Page->utamahargatotalorder->caption() ?></span></td>
        <td data-name="utamahargatotalorder" <?= $Page->utamahargatotalorder->cellAttributes() ?>>
<span id="el_npd_terms_utamahargatotalorder">
<span<?= $Page->utamahargatotalorder->viewAttributes() ?>>
<?= $Page->utamahargatotalorder->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ukuranlain->Visible) { // ukuranlain ?>
    <tr id="r_ukuranlain">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_ukuranlain"><?= $Page->ukuranlain->caption() ?></span></td>
        <td data-name="ukuranlain" <?= $Page->ukuranlain->cellAttributes() ?>>
<span id="el_npd_terms_ukuranlain">
<span<?= $Page->ukuranlain->viewAttributes() ?>>
<?= $Page->ukuranlain->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lainhargaisipcs->Visible) { // lainhargaisipcs ?>
    <tr id="r_lainhargaisipcs">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_lainhargaisipcs"><?= $Page->lainhargaisipcs->caption() ?></span></td>
        <td data-name="lainhargaisipcs" <?= $Page->lainhargaisipcs->cellAttributes() ?>>
<span id="el_npd_terms_lainhargaisipcs">
<span<?= $Page->lainhargaisipcs->viewAttributes() ?>>
<?= $Page->lainhargaisipcs->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lainhargaprimerpcs->Visible) { // lainhargaprimerpcs ?>
    <tr id="r_lainhargaprimerpcs">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_lainhargaprimerpcs"><?= $Page->lainhargaprimerpcs->caption() ?></span></td>
        <td data-name="lainhargaprimerpcs" <?= $Page->lainhargaprimerpcs->cellAttributes() ?>>
<span id="el_npd_terms_lainhargaprimerpcs">
<span<?= $Page->lainhargaprimerpcs->viewAttributes() ?>>
<?= $Page->lainhargaprimerpcs->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lainhargasekunderpcs->Visible) { // lainhargasekunderpcs ?>
    <tr id="r_lainhargasekunderpcs">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_lainhargasekunderpcs"><?= $Page->lainhargasekunderpcs->caption() ?></span></td>
        <td data-name="lainhargasekunderpcs" <?= $Page->lainhargasekunderpcs->cellAttributes() ?>>
<span id="el_npd_terms_lainhargasekunderpcs">
<span<?= $Page->lainhargasekunderpcs->viewAttributes() ?>>
<?= $Page->lainhargasekunderpcs->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lainhargalabelpcs->Visible) { // lainhargalabelpcs ?>
    <tr id="r_lainhargalabelpcs">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_lainhargalabelpcs"><?= $Page->lainhargalabelpcs->caption() ?></span></td>
        <td data-name="lainhargalabelpcs" <?= $Page->lainhargalabelpcs->cellAttributes() ?>>
<span id="el_npd_terms_lainhargalabelpcs">
<span<?= $Page->lainhargalabelpcs->viewAttributes() ?>>
<?= $Page->lainhargalabelpcs->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lainhargatotalpcs->Visible) { // lainhargatotalpcs ?>
    <tr id="r_lainhargatotalpcs">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_lainhargatotalpcs"><?= $Page->lainhargatotalpcs->caption() ?></span></td>
        <td data-name="lainhargatotalpcs" <?= $Page->lainhargatotalpcs->cellAttributes() ?>>
<span id="el_npd_terms_lainhargatotalpcs">
<span<?= $Page->lainhargatotalpcs->viewAttributes() ?>>
<?= $Page->lainhargatotalpcs->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lainhargaisiorder->Visible) { // lainhargaisiorder ?>
    <tr id="r_lainhargaisiorder">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_lainhargaisiorder"><?= $Page->lainhargaisiorder->caption() ?></span></td>
        <td data-name="lainhargaisiorder" <?= $Page->lainhargaisiorder->cellAttributes() ?>>
<span id="el_npd_terms_lainhargaisiorder">
<span<?= $Page->lainhargaisiorder->viewAttributes() ?>>
<?= $Page->lainhargaisiorder->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lainhargaprimerorder->Visible) { // lainhargaprimerorder ?>
    <tr id="r_lainhargaprimerorder">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_lainhargaprimerorder"><?= $Page->lainhargaprimerorder->caption() ?></span></td>
        <td data-name="lainhargaprimerorder" <?= $Page->lainhargaprimerorder->cellAttributes() ?>>
<span id="el_npd_terms_lainhargaprimerorder">
<span<?= $Page->lainhargaprimerorder->viewAttributes() ?>>
<?= $Page->lainhargaprimerorder->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lainhargasekunderorder->Visible) { // lainhargasekunderorder ?>
    <tr id="r_lainhargasekunderorder">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_lainhargasekunderorder"><?= $Page->lainhargasekunderorder->caption() ?></span></td>
        <td data-name="lainhargasekunderorder" <?= $Page->lainhargasekunderorder->cellAttributes() ?>>
<span id="el_npd_terms_lainhargasekunderorder">
<span<?= $Page->lainhargasekunderorder->viewAttributes() ?>>
<?= $Page->lainhargasekunderorder->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lainhargalabelorder->Visible) { // lainhargalabelorder ?>
    <tr id="r_lainhargalabelorder">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_lainhargalabelorder"><?= $Page->lainhargalabelorder->caption() ?></span></td>
        <td data-name="lainhargalabelorder" <?= $Page->lainhargalabelorder->cellAttributes() ?>>
<span id="el_npd_terms_lainhargalabelorder">
<span<?= $Page->lainhargalabelorder->viewAttributes() ?>>
<?= $Page->lainhargalabelorder->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lainhargatotalorder->Visible) { // lainhargatotalorder ?>
    <tr id="r_lainhargatotalorder">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_lainhargatotalorder"><?= $Page->lainhargatotalorder->caption() ?></span></td>
        <td data-name="lainhargatotalorder" <?= $Page->lainhargatotalorder->cellAttributes() ?>>
<span id="el_npd_terms_lainhargatotalorder">
<span<?= $Page->lainhargatotalorder->viewAttributes() ?>>
<?= $Page->lainhargatotalorder->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->isibahanaktif->Visible) { // isibahanaktif ?>
    <tr id="r_isibahanaktif">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_isibahanaktif"><?= $Page->isibahanaktif->caption() ?></span></td>
        <td data-name="isibahanaktif" <?= $Page->isibahanaktif->cellAttributes() ?>>
<span id="el_npd_terms_isibahanaktif">
<span<?= $Page->isibahanaktif->viewAttributes() ?>>
<?= $Page->isibahanaktif->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->isibahanlain->Visible) { // isibahanlain ?>
    <tr id="r_isibahanlain">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_isibahanlain"><?= $Page->isibahanlain->caption() ?></span></td>
        <td data-name="isibahanlain" <?= $Page->isibahanlain->cellAttributes() ?>>
<span id="el_npd_terms_isibahanlain">
<span<?= $Page->isibahanlain->viewAttributes() ?>>
<?= $Page->isibahanlain->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->isiparfum->Visible) { // isiparfum ?>
    <tr id="r_isiparfum">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_isiparfum"><?= $Page->isiparfum->caption() ?></span></td>
        <td data-name="isiparfum" <?= $Page->isiparfum->cellAttributes() ?>>
<span id="el_npd_terms_isiparfum">
<span<?= $Page->isiparfum->viewAttributes() ?>>
<?= $Page->isiparfum->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->isiestetika->Visible) { // isiestetika ?>
    <tr id="r_isiestetika">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_isiestetika"><?= $Page->isiestetika->caption() ?></span></td>
        <td data-name="isiestetika" <?= $Page->isiestetika->cellAttributes() ?>>
<span id="el_npd_terms_isiestetika">
<span<?= $Page->isiestetika->viewAttributes() ?>>
<?= $Page->isiestetika->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kemasanwadah->Visible) { // kemasanwadah ?>
    <tr id="r_kemasanwadah">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_kemasanwadah"><?= $Page->kemasanwadah->caption() ?></span></td>
        <td data-name="kemasanwadah" <?= $Page->kemasanwadah->cellAttributes() ?>>
<span id="el_npd_terms_kemasanwadah">
<span<?= $Page->kemasanwadah->viewAttributes() ?>>
<?= $Page->kemasanwadah->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kemasantutup->Visible) { // kemasantutup ?>
    <tr id="r_kemasantutup">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_kemasantutup"><?= $Page->kemasantutup->caption() ?></span></td>
        <td data-name="kemasantutup" <?= $Page->kemasantutup->cellAttributes() ?>>
<span id="el_npd_terms_kemasantutup">
<span<?= $Page->kemasantutup->viewAttributes() ?>>
<?= $Page->kemasantutup->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kemasansekunder->Visible) { // kemasansekunder ?>
    <tr id="r_kemasansekunder">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_kemasansekunder"><?= $Page->kemasansekunder->caption() ?></span></td>
        <td data-name="kemasansekunder" <?= $Page->kemasansekunder->cellAttributes() ?>>
<span id="el_npd_terms_kemasansekunder">
<span<?= $Page->kemasansekunder->viewAttributes() ?>>
<?= $Page->kemasansekunder->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->desainlabel->Visible) { // desainlabel ?>
    <tr id="r_desainlabel">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_desainlabel"><?= $Page->desainlabel->caption() ?></span></td>
        <td data-name="desainlabel" <?= $Page->desainlabel->cellAttributes() ?>>
<span id="el_npd_terms_desainlabel">
<span<?= $Page->desainlabel->viewAttributes() ?>>
<?= $Page->desainlabel->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cetaklabel->Visible) { // cetaklabel ?>
    <tr id="r_cetaklabel">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_cetaklabel"><?= $Page->cetaklabel->caption() ?></span></td>
        <td data-name="cetaklabel" <?= $Page->cetaklabel->cellAttributes() ?>>
<span id="el_npd_terms_cetaklabel">
<span<?= $Page->cetaklabel->viewAttributes() ?>>
<?= $Page->cetaklabel->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lainlain->Visible) { // lainlain ?>
    <tr id="r_lainlain">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_lainlain"><?= $Page->lainlain->caption() ?></span></td>
        <td data-name="lainlain" <?= $Page->lainlain->cellAttributes() ?>>
<span id="el_npd_terms_lainlain">
<span<?= $Page->lainlain->viewAttributes() ?>>
<?= $Page->lainlain->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->deliverypickup->Visible) { // deliverypickup ?>
    <tr id="r_deliverypickup">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_deliverypickup"><?= $Page->deliverypickup->caption() ?></span></td>
        <td data-name="deliverypickup" <?= $Page->deliverypickup->cellAttributes() ?>>
<span id="el_npd_terms_deliverypickup">
<span<?= $Page->deliverypickup->viewAttributes() ?>>
<?= $Page->deliverypickup->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->deliverysinglepoint->Visible) { // deliverysinglepoint ?>
    <tr id="r_deliverysinglepoint">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_deliverysinglepoint"><?= $Page->deliverysinglepoint->caption() ?></span></td>
        <td data-name="deliverysinglepoint" <?= $Page->deliverysinglepoint->cellAttributes() ?>>
<span id="el_npd_terms_deliverysinglepoint">
<span<?= $Page->deliverysinglepoint->viewAttributes() ?>>
<?= $Page->deliverysinglepoint->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->deliverymultipoint->Visible) { // deliverymultipoint ?>
    <tr id="r_deliverymultipoint">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_deliverymultipoint"><?= $Page->deliverymultipoint->caption() ?></span></td>
        <td data-name="deliverymultipoint" <?= $Page->deliverymultipoint->cellAttributes() ?>>
<span id="el_npd_terms_deliverymultipoint">
<span<?= $Page->deliverymultipoint->viewAttributes() ?>>
<?= $Page->deliverymultipoint->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->deliveryjumlahpoint->Visible) { // deliveryjumlahpoint ?>
    <tr id="r_deliveryjumlahpoint">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_deliveryjumlahpoint"><?= $Page->deliveryjumlahpoint->caption() ?></span></td>
        <td data-name="deliveryjumlahpoint" <?= $Page->deliveryjumlahpoint->cellAttributes() ?>>
<span id="el_npd_terms_deliveryjumlahpoint">
<span<?= $Page->deliveryjumlahpoint->viewAttributes() ?>>
<?= $Page->deliveryjumlahpoint->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->deliverytermslain->Visible) { // deliverytermslain ?>
    <tr id="r_deliverytermslain">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_deliverytermslain"><?= $Page->deliverytermslain->caption() ?></span></td>
        <td data-name="deliverytermslain" <?= $Page->deliverytermslain->cellAttributes() ?>>
<span id="el_npd_terms_deliverytermslain">
<span<?= $Page->deliverytermslain->viewAttributes() ?>>
<?= $Page->deliverytermslain->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->catatankhusus->Visible) { // catatankhusus ?>
    <tr id="r_catatankhusus">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_catatankhusus"><?= $Page->catatankhusus->caption() ?></span></td>
        <td data-name="catatankhusus" <?= $Page->catatankhusus->cellAttributes() ?>>
<span id="el_npd_terms_catatankhusus">
<span<?= $Page->catatankhusus->viewAttributes() ?>>
<?= $Page->catatankhusus->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dibuatdi->Visible) { // dibuatdi ?>
    <tr id="r_dibuatdi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_dibuatdi"><?= $Page->dibuatdi->caption() ?></span></td>
        <td data-name="dibuatdi" <?= $Page->dibuatdi->cellAttributes() ?>>
<span id="el_npd_terms_dibuatdi">
<span<?= $Page->dibuatdi->viewAttributes() ?>>
<?= $Page->dibuatdi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tanggal->Visible) { // tanggal ?>
    <tr id="r_tanggal">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_tanggal"><?= $Page->tanggal->caption() ?></span></td>
        <td data-name="tanggal" <?= $Page->tanggal->cellAttributes() ?>>
<span id="el_npd_terms_tanggal">
<span<?= $Page->tanggal->viewAttributes() ?>>
<?= $Page->tanggal->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->created_by->Visible) { // created_by ?>
    <tr id="r_created_by">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_created_by"><?= $Page->created_by->caption() ?></span></td>
        <td data-name="created_by" <?= $Page->created_by->cellAttributes() ?>>
<span id="el_npd_terms_created_by">
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

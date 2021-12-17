<?php

namespace PHPMaker2021\Dermateknonew;

// Page object
$NpdTermsEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fnpd_termsedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fnpd_termsedit = currentForm = new ew.Form("fnpd_termsedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "npd_terms")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.npd_terms)
        ew.vars.tables.npd_terms = currentTable;
    fnpd_termsedit.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["idnpd", [fields.idnpd.visible && fields.idnpd.required ? ew.Validators.required(fields.idnpd.caption) : null, ew.Validators.integer], fields.idnpd.isInvalid],
        ["status", [fields.status.visible && fields.status.required ? ew.Validators.required(fields.status.caption) : null], fields.status.isInvalid],
        ["tglsubmit", [fields.tglsubmit.visible && fields.tglsubmit.required ? ew.Validators.required(fields.tglsubmit.caption) : null, ew.Validators.datetime(0)], fields.tglsubmit.isInvalid],
        ["sifatorder", [fields.sifatorder.visible && fields.sifatorder.required ? ew.Validators.required(fields.sifatorder.caption) : null], fields.sifatorder.isInvalid],
        ["ukuranutama", [fields.ukuranutama.visible && fields.ukuranutama.required ? ew.Validators.required(fields.ukuranutama.caption) : null], fields.ukuranutama.isInvalid],
        ["utamahargaisipcs", [fields.utamahargaisipcs.visible && fields.utamahargaisipcs.required ? ew.Validators.required(fields.utamahargaisipcs.caption) : null, ew.Validators.integer], fields.utamahargaisipcs.isInvalid],
        ["utamahargaprimerpcs", [fields.utamahargaprimerpcs.visible && fields.utamahargaprimerpcs.required ? ew.Validators.required(fields.utamahargaprimerpcs.caption) : null, ew.Validators.integer], fields.utamahargaprimerpcs.isInvalid],
        ["utamahargasekunderpcs", [fields.utamahargasekunderpcs.visible && fields.utamahargasekunderpcs.required ? ew.Validators.required(fields.utamahargasekunderpcs.caption) : null, ew.Validators.integer], fields.utamahargasekunderpcs.isInvalid],
        ["utamahargalabelpcs", [fields.utamahargalabelpcs.visible && fields.utamahargalabelpcs.required ? ew.Validators.required(fields.utamahargalabelpcs.caption) : null, ew.Validators.integer], fields.utamahargalabelpcs.isInvalid],
        ["utamahargatotalpcs", [fields.utamahargatotalpcs.visible && fields.utamahargatotalpcs.required ? ew.Validators.required(fields.utamahargatotalpcs.caption) : null, ew.Validators.integer], fields.utamahargatotalpcs.isInvalid],
        ["utamahargaisiorder", [fields.utamahargaisiorder.visible && fields.utamahargaisiorder.required ? ew.Validators.required(fields.utamahargaisiorder.caption) : null, ew.Validators.integer], fields.utamahargaisiorder.isInvalid],
        ["utamahargaprimerorder", [fields.utamahargaprimerorder.visible && fields.utamahargaprimerorder.required ? ew.Validators.required(fields.utamahargaprimerorder.caption) : null, ew.Validators.integer], fields.utamahargaprimerorder.isInvalid],
        ["utamahargasekunderorder", [fields.utamahargasekunderorder.visible && fields.utamahargasekunderorder.required ? ew.Validators.required(fields.utamahargasekunderorder.caption) : null, ew.Validators.integer], fields.utamahargasekunderorder.isInvalid],
        ["utamahargalabelorder", [fields.utamahargalabelorder.visible && fields.utamahargalabelorder.required ? ew.Validators.required(fields.utamahargalabelorder.caption) : null, ew.Validators.integer], fields.utamahargalabelorder.isInvalid],
        ["utamahargatotalorder", [fields.utamahargatotalorder.visible && fields.utamahargatotalorder.required ? ew.Validators.required(fields.utamahargatotalorder.caption) : null, ew.Validators.integer], fields.utamahargatotalorder.isInvalid],
        ["ukuranlain", [fields.ukuranlain.visible && fields.ukuranlain.required ? ew.Validators.required(fields.ukuranlain.caption) : null], fields.ukuranlain.isInvalid],
        ["lainhargaisipcs", [fields.lainhargaisipcs.visible && fields.lainhargaisipcs.required ? ew.Validators.required(fields.lainhargaisipcs.caption) : null, ew.Validators.integer], fields.lainhargaisipcs.isInvalid],
        ["lainhargaprimerpcs", [fields.lainhargaprimerpcs.visible && fields.lainhargaprimerpcs.required ? ew.Validators.required(fields.lainhargaprimerpcs.caption) : null, ew.Validators.integer], fields.lainhargaprimerpcs.isInvalid],
        ["lainhargasekunderpcs", [fields.lainhargasekunderpcs.visible && fields.lainhargasekunderpcs.required ? ew.Validators.required(fields.lainhargasekunderpcs.caption) : null, ew.Validators.integer], fields.lainhargasekunderpcs.isInvalid],
        ["lainhargalabelpcs", [fields.lainhargalabelpcs.visible && fields.lainhargalabelpcs.required ? ew.Validators.required(fields.lainhargalabelpcs.caption) : null, ew.Validators.integer], fields.lainhargalabelpcs.isInvalid],
        ["lainhargatotalpcs", [fields.lainhargatotalpcs.visible && fields.lainhargatotalpcs.required ? ew.Validators.required(fields.lainhargatotalpcs.caption) : null, ew.Validators.integer], fields.lainhargatotalpcs.isInvalid],
        ["lainhargaisiorder", [fields.lainhargaisiorder.visible && fields.lainhargaisiorder.required ? ew.Validators.required(fields.lainhargaisiorder.caption) : null, ew.Validators.integer], fields.lainhargaisiorder.isInvalid],
        ["lainhargaprimerorder", [fields.lainhargaprimerorder.visible && fields.lainhargaprimerorder.required ? ew.Validators.required(fields.lainhargaprimerorder.caption) : null, ew.Validators.integer], fields.lainhargaprimerorder.isInvalid],
        ["lainhargasekunderorder", [fields.lainhargasekunderorder.visible && fields.lainhargasekunderorder.required ? ew.Validators.required(fields.lainhargasekunderorder.caption) : null, ew.Validators.integer], fields.lainhargasekunderorder.isInvalid],
        ["lainhargalabelorder", [fields.lainhargalabelorder.visible && fields.lainhargalabelorder.required ? ew.Validators.required(fields.lainhargalabelorder.caption) : null, ew.Validators.integer], fields.lainhargalabelorder.isInvalid],
        ["lainhargatotalorder", [fields.lainhargatotalorder.visible && fields.lainhargatotalorder.required ? ew.Validators.required(fields.lainhargatotalorder.caption) : null, ew.Validators.integer], fields.lainhargatotalorder.isInvalid],
        ["isibahanaktif", [fields.isibahanaktif.visible && fields.isibahanaktif.required ? ew.Validators.required(fields.isibahanaktif.caption) : null], fields.isibahanaktif.isInvalid],
        ["isibahanlain", [fields.isibahanlain.visible && fields.isibahanlain.required ? ew.Validators.required(fields.isibahanlain.caption) : null], fields.isibahanlain.isInvalid],
        ["isiparfum", [fields.isiparfum.visible && fields.isiparfum.required ? ew.Validators.required(fields.isiparfum.caption) : null], fields.isiparfum.isInvalid],
        ["isiestetika", [fields.isiestetika.visible && fields.isiestetika.required ? ew.Validators.required(fields.isiestetika.caption) : null], fields.isiestetika.isInvalid],
        ["kemasanwadah", [fields.kemasanwadah.visible && fields.kemasanwadah.required ? ew.Validators.required(fields.kemasanwadah.caption) : null, ew.Validators.integer], fields.kemasanwadah.isInvalid],
        ["kemasantutup", [fields.kemasantutup.visible && fields.kemasantutup.required ? ew.Validators.required(fields.kemasantutup.caption) : null, ew.Validators.integer], fields.kemasantutup.isInvalid],
        ["kemasansekunder", [fields.kemasansekunder.visible && fields.kemasansekunder.required ? ew.Validators.required(fields.kemasansekunder.caption) : null], fields.kemasansekunder.isInvalid],
        ["desainlabel", [fields.desainlabel.visible && fields.desainlabel.required ? ew.Validators.required(fields.desainlabel.caption) : null], fields.desainlabel.isInvalid],
        ["cetaklabel", [fields.cetaklabel.visible && fields.cetaklabel.required ? ew.Validators.required(fields.cetaklabel.caption) : null], fields.cetaklabel.isInvalid],
        ["lainlain", [fields.lainlain.visible && fields.lainlain.required ? ew.Validators.required(fields.lainlain.caption) : null], fields.lainlain.isInvalid],
        ["deliverypickup", [fields.deliverypickup.visible && fields.deliverypickup.required ? ew.Validators.required(fields.deliverypickup.caption) : null], fields.deliverypickup.isInvalid],
        ["deliverysinglepoint", [fields.deliverysinglepoint.visible && fields.deliverysinglepoint.required ? ew.Validators.required(fields.deliverysinglepoint.caption) : null], fields.deliverysinglepoint.isInvalid],
        ["deliverymultipoint", [fields.deliverymultipoint.visible && fields.deliverymultipoint.required ? ew.Validators.required(fields.deliverymultipoint.caption) : null], fields.deliverymultipoint.isInvalid],
        ["deliveryjumlahpoint", [fields.deliveryjumlahpoint.visible && fields.deliveryjumlahpoint.required ? ew.Validators.required(fields.deliveryjumlahpoint.caption) : null], fields.deliveryjumlahpoint.isInvalid],
        ["deliverytermslain", [fields.deliverytermslain.visible && fields.deliverytermslain.required ? ew.Validators.required(fields.deliverytermslain.caption) : null], fields.deliverytermslain.isInvalid],
        ["catatankhusus", [fields.catatankhusus.visible && fields.catatankhusus.required ? ew.Validators.required(fields.catatankhusus.caption) : null], fields.catatankhusus.isInvalid],
        ["dibuatdi", [fields.dibuatdi.visible && fields.dibuatdi.required ? ew.Validators.required(fields.dibuatdi.caption) : null], fields.dibuatdi.isInvalid],
        ["tanggal", [fields.tanggal.visible && fields.tanggal.required ? ew.Validators.required(fields.tanggal.caption) : null, ew.Validators.datetime(0)], fields.tanggal.isInvalid],
        ["created_by", [fields.created_by.visible && fields.created_by.required ? ew.Validators.required(fields.created_by.caption) : null, ew.Validators.integer], fields.created_by.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fnpd_termsedit,
            fobj = f.getForm(),
            $fobj = $(fobj),
            $k = $fobj.find("#" + f.formKeyCountName), // Get key_count
            rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1,
            startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
        for (var i = startcnt; i <= rowcnt; i++) {
            var rowIndex = ($k[0]) ? String(i) : "";
            f.setInvalid(rowIndex);
        }
    });

    // Validate form
    fnpd_termsedit.validate = function () {
        if (!this.validateRequired)
            return true; // Ignore validation
        var fobj = this.getForm(),
            $fobj = $(fobj);
        if ($fobj.find("#confirm").val() == "confirm")
            return true;
        var addcnt = 0,
            $k = $fobj.find("#" + this.formKeyCountName), // Get key_count
            rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1,
            startcnt = (rowcnt == 0) ? 0 : 1, // Check rowcnt == 0 => Inline-Add
            gridinsert = ["insert", "gridinsert"].includes($fobj.find("#action").val()) && $k[0];
        for (var i = startcnt; i <= rowcnt; i++) {
            var rowIndex = ($k[0]) ? String(i) : "";
            $fobj.data("rowindex", rowIndex);

            // Validate fields
            if (!this.validateFields(rowIndex))
                return false;

            // Call Form_CustomValidate event
            if (!this.customValidate(fobj)) {
                this.focus();
                return false;
            }
        }

        // Process detail forms
        var dfs = $fobj.find("input[name='detailpage']").get();
        for (var i = 0; i < dfs.length; i++) {
            var df = dfs[i],
                val = df.value,
                frm = ew.forms.get(val);
            if (val && frm && !frm.validate())
                return false;
        }
        return true;
    }

    // Form_CustomValidate
    fnpd_termsedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fnpd_termsedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fnpd_termsedit.lists.sifatorder = <?= $Page->sifatorder->toClientList($Page) ?>;
    loadjs.done("fnpd_termsedit");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fnpd_termsedit" id="fnpd_termsedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_terms">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id" class="form-group row">
        <label id="elh_npd_terms_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id->cellAttributes() ?>>
<span id="el_npd_terms_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idnpd->Visible) { // idnpd ?>
    <div id="r_idnpd" class="form-group row">
        <label id="elh_npd_terms_idnpd" for="x_idnpd" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idnpd->caption() ?><?= $Page->idnpd->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idnpd->cellAttributes() ?>>
<span id="el_npd_terms_idnpd">
<input type="<?= $Page->idnpd->getInputTextType() ?>" data-table="npd_terms" data-field="x_idnpd" name="x_idnpd" id="x_idnpd" size="30" placeholder="<?= HtmlEncode($Page->idnpd->getPlaceHolder()) ?>" value="<?= $Page->idnpd->EditValue ?>"<?= $Page->idnpd->editAttributes() ?> aria-describedby="x_idnpd_help">
<?= $Page->idnpd->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->idnpd->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <div id="r_status" class="form-group row">
        <label id="elh_npd_terms_status" for="x_status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status->caption() ?><?= $Page->status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->status->cellAttributes() ?>>
<span id="el_npd_terms_status">
<input type="<?= $Page->status->getInputTextType() ?>" data-table="npd_terms" data-field="x_status" name="x_status" id="x_status" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->status->getPlaceHolder()) ?>" value="<?= $Page->status->EditValue ?>"<?= $Page->status->editAttributes() ?> aria-describedby="x_status_help">
<?= $Page->status->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->status->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tglsubmit->Visible) { // tglsubmit ?>
    <div id="r_tglsubmit" class="form-group row">
        <label id="elh_npd_terms_tglsubmit" for="x_tglsubmit" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tglsubmit->caption() ?><?= $Page->tglsubmit->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tglsubmit->cellAttributes() ?>>
<span id="el_npd_terms_tglsubmit">
<input type="<?= $Page->tglsubmit->getInputTextType() ?>" data-table="npd_terms" data-field="x_tglsubmit" name="x_tglsubmit" id="x_tglsubmit" placeholder="<?= HtmlEncode($Page->tglsubmit->getPlaceHolder()) ?>" value="<?= $Page->tglsubmit->EditValue ?>"<?= $Page->tglsubmit->editAttributes() ?> aria-describedby="x_tglsubmit_help">
<?= $Page->tglsubmit->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tglsubmit->getErrorMessage() ?></div>
<?php if (!$Page->tglsubmit->ReadOnly && !$Page->tglsubmit->Disabled && !isset($Page->tglsubmit->EditAttrs["readonly"]) && !isset($Page->tglsubmit->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_termsedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_termsedit", "x_tglsubmit", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->sifatorder->Visible) { // sifatorder ?>
    <div id="r_sifatorder" class="form-group row">
        <label id="elh_npd_terms_sifatorder" class="<?= $Page->LeftColumnClass ?>"><?= $Page->sifatorder->caption() ?><?= $Page->sifatorder->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->sifatorder->cellAttributes() ?>>
<span id="el_npd_terms_sifatorder">
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" class="custom-control-input<?= $Page->sifatorder->isInvalidClass() ?>" data-table="npd_terms" data-field="x_sifatorder" name="x_sifatorder[]" id="x_sifatorder_364115" value="1"<?= ConvertToBool($Page->sifatorder->CurrentValue) ? " checked" : "" ?><?= $Page->sifatorder->editAttributes() ?> aria-describedby="x_sifatorder_help">
    <label class="custom-control-label" for="x_sifatorder_364115"></label>
</div>
<?= $Page->sifatorder->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->sifatorder->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ukuranutama->Visible) { // ukuranutama ?>
    <div id="r_ukuranutama" class="form-group row">
        <label id="elh_npd_terms_ukuranutama" for="x_ukuranutama" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ukuranutama->caption() ?><?= $Page->ukuranutama->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ukuranutama->cellAttributes() ?>>
<span id="el_npd_terms_ukuranutama">
<input type="<?= $Page->ukuranutama->getInputTextType() ?>" data-table="npd_terms" data-field="x_ukuranutama" name="x_ukuranutama" id="x_ukuranutama" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->ukuranutama->getPlaceHolder()) ?>" value="<?= $Page->ukuranutama->EditValue ?>"<?= $Page->ukuranutama->editAttributes() ?> aria-describedby="x_ukuranutama_help">
<?= $Page->ukuranutama->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ukuranutama->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->utamahargaisipcs->Visible) { // utamahargaisipcs ?>
    <div id="r_utamahargaisipcs" class="form-group row">
        <label id="elh_npd_terms_utamahargaisipcs" for="x_utamahargaisipcs" class="<?= $Page->LeftColumnClass ?>"><?= $Page->utamahargaisipcs->caption() ?><?= $Page->utamahargaisipcs->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->utamahargaisipcs->cellAttributes() ?>>
<span id="el_npd_terms_utamahargaisipcs">
<input type="<?= $Page->utamahargaisipcs->getInputTextType() ?>" data-table="npd_terms" data-field="x_utamahargaisipcs" name="x_utamahargaisipcs" id="x_utamahargaisipcs" size="30" placeholder="<?= HtmlEncode($Page->utamahargaisipcs->getPlaceHolder()) ?>" value="<?= $Page->utamahargaisipcs->EditValue ?>"<?= $Page->utamahargaisipcs->editAttributes() ?> aria-describedby="x_utamahargaisipcs_help">
<?= $Page->utamahargaisipcs->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->utamahargaisipcs->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->utamahargaprimerpcs->Visible) { // utamahargaprimerpcs ?>
    <div id="r_utamahargaprimerpcs" class="form-group row">
        <label id="elh_npd_terms_utamahargaprimerpcs" for="x_utamahargaprimerpcs" class="<?= $Page->LeftColumnClass ?>"><?= $Page->utamahargaprimerpcs->caption() ?><?= $Page->utamahargaprimerpcs->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->utamahargaprimerpcs->cellAttributes() ?>>
<span id="el_npd_terms_utamahargaprimerpcs">
<input type="<?= $Page->utamahargaprimerpcs->getInputTextType() ?>" data-table="npd_terms" data-field="x_utamahargaprimerpcs" name="x_utamahargaprimerpcs" id="x_utamahargaprimerpcs" size="30" placeholder="<?= HtmlEncode($Page->utamahargaprimerpcs->getPlaceHolder()) ?>" value="<?= $Page->utamahargaprimerpcs->EditValue ?>"<?= $Page->utamahargaprimerpcs->editAttributes() ?> aria-describedby="x_utamahargaprimerpcs_help">
<?= $Page->utamahargaprimerpcs->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->utamahargaprimerpcs->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->utamahargasekunderpcs->Visible) { // utamahargasekunderpcs ?>
    <div id="r_utamahargasekunderpcs" class="form-group row">
        <label id="elh_npd_terms_utamahargasekunderpcs" for="x_utamahargasekunderpcs" class="<?= $Page->LeftColumnClass ?>"><?= $Page->utamahargasekunderpcs->caption() ?><?= $Page->utamahargasekunderpcs->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->utamahargasekunderpcs->cellAttributes() ?>>
<span id="el_npd_terms_utamahargasekunderpcs">
<input type="<?= $Page->utamahargasekunderpcs->getInputTextType() ?>" data-table="npd_terms" data-field="x_utamahargasekunderpcs" name="x_utamahargasekunderpcs" id="x_utamahargasekunderpcs" size="30" placeholder="<?= HtmlEncode($Page->utamahargasekunderpcs->getPlaceHolder()) ?>" value="<?= $Page->utamahargasekunderpcs->EditValue ?>"<?= $Page->utamahargasekunderpcs->editAttributes() ?> aria-describedby="x_utamahargasekunderpcs_help">
<?= $Page->utamahargasekunderpcs->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->utamahargasekunderpcs->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->utamahargalabelpcs->Visible) { // utamahargalabelpcs ?>
    <div id="r_utamahargalabelpcs" class="form-group row">
        <label id="elh_npd_terms_utamahargalabelpcs" for="x_utamahargalabelpcs" class="<?= $Page->LeftColumnClass ?>"><?= $Page->utamahargalabelpcs->caption() ?><?= $Page->utamahargalabelpcs->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->utamahargalabelpcs->cellAttributes() ?>>
<span id="el_npd_terms_utamahargalabelpcs">
<input type="<?= $Page->utamahargalabelpcs->getInputTextType() ?>" data-table="npd_terms" data-field="x_utamahargalabelpcs" name="x_utamahargalabelpcs" id="x_utamahargalabelpcs" size="30" placeholder="<?= HtmlEncode($Page->utamahargalabelpcs->getPlaceHolder()) ?>" value="<?= $Page->utamahargalabelpcs->EditValue ?>"<?= $Page->utamahargalabelpcs->editAttributes() ?> aria-describedby="x_utamahargalabelpcs_help">
<?= $Page->utamahargalabelpcs->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->utamahargalabelpcs->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->utamahargatotalpcs->Visible) { // utamahargatotalpcs ?>
    <div id="r_utamahargatotalpcs" class="form-group row">
        <label id="elh_npd_terms_utamahargatotalpcs" for="x_utamahargatotalpcs" class="<?= $Page->LeftColumnClass ?>"><?= $Page->utamahargatotalpcs->caption() ?><?= $Page->utamahargatotalpcs->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->utamahargatotalpcs->cellAttributes() ?>>
<span id="el_npd_terms_utamahargatotalpcs">
<input type="<?= $Page->utamahargatotalpcs->getInputTextType() ?>" data-table="npd_terms" data-field="x_utamahargatotalpcs" name="x_utamahargatotalpcs" id="x_utamahargatotalpcs" size="30" placeholder="<?= HtmlEncode($Page->utamahargatotalpcs->getPlaceHolder()) ?>" value="<?= $Page->utamahargatotalpcs->EditValue ?>"<?= $Page->utamahargatotalpcs->editAttributes() ?> aria-describedby="x_utamahargatotalpcs_help">
<?= $Page->utamahargatotalpcs->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->utamahargatotalpcs->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->utamahargaisiorder->Visible) { // utamahargaisiorder ?>
    <div id="r_utamahargaisiorder" class="form-group row">
        <label id="elh_npd_terms_utamahargaisiorder" for="x_utamahargaisiorder" class="<?= $Page->LeftColumnClass ?>"><?= $Page->utamahargaisiorder->caption() ?><?= $Page->utamahargaisiorder->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->utamahargaisiorder->cellAttributes() ?>>
<span id="el_npd_terms_utamahargaisiorder">
<input type="<?= $Page->utamahargaisiorder->getInputTextType() ?>" data-table="npd_terms" data-field="x_utamahargaisiorder" name="x_utamahargaisiorder" id="x_utamahargaisiorder" size="30" placeholder="<?= HtmlEncode($Page->utamahargaisiorder->getPlaceHolder()) ?>" value="<?= $Page->utamahargaisiorder->EditValue ?>"<?= $Page->utamahargaisiorder->editAttributes() ?> aria-describedby="x_utamahargaisiorder_help">
<?= $Page->utamahargaisiorder->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->utamahargaisiorder->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->utamahargaprimerorder->Visible) { // utamahargaprimerorder ?>
    <div id="r_utamahargaprimerorder" class="form-group row">
        <label id="elh_npd_terms_utamahargaprimerorder" for="x_utamahargaprimerorder" class="<?= $Page->LeftColumnClass ?>"><?= $Page->utamahargaprimerorder->caption() ?><?= $Page->utamahargaprimerorder->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->utamahargaprimerorder->cellAttributes() ?>>
<span id="el_npd_terms_utamahargaprimerorder">
<input type="<?= $Page->utamahargaprimerorder->getInputTextType() ?>" data-table="npd_terms" data-field="x_utamahargaprimerorder" name="x_utamahargaprimerorder" id="x_utamahargaprimerorder" size="30" placeholder="<?= HtmlEncode($Page->utamahargaprimerorder->getPlaceHolder()) ?>" value="<?= $Page->utamahargaprimerorder->EditValue ?>"<?= $Page->utamahargaprimerorder->editAttributes() ?> aria-describedby="x_utamahargaprimerorder_help">
<?= $Page->utamahargaprimerorder->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->utamahargaprimerorder->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->utamahargasekunderorder->Visible) { // utamahargasekunderorder ?>
    <div id="r_utamahargasekunderorder" class="form-group row">
        <label id="elh_npd_terms_utamahargasekunderorder" for="x_utamahargasekunderorder" class="<?= $Page->LeftColumnClass ?>"><?= $Page->utamahargasekunderorder->caption() ?><?= $Page->utamahargasekunderorder->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->utamahargasekunderorder->cellAttributes() ?>>
<span id="el_npd_terms_utamahargasekunderorder">
<input type="<?= $Page->utamahargasekunderorder->getInputTextType() ?>" data-table="npd_terms" data-field="x_utamahargasekunderorder" name="x_utamahargasekunderorder" id="x_utamahargasekunderorder" size="30" placeholder="<?= HtmlEncode($Page->utamahargasekunderorder->getPlaceHolder()) ?>" value="<?= $Page->utamahargasekunderorder->EditValue ?>"<?= $Page->utamahargasekunderorder->editAttributes() ?> aria-describedby="x_utamahargasekunderorder_help">
<?= $Page->utamahargasekunderorder->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->utamahargasekunderorder->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->utamahargalabelorder->Visible) { // utamahargalabelorder ?>
    <div id="r_utamahargalabelorder" class="form-group row">
        <label id="elh_npd_terms_utamahargalabelorder" for="x_utamahargalabelorder" class="<?= $Page->LeftColumnClass ?>"><?= $Page->utamahargalabelorder->caption() ?><?= $Page->utamahargalabelorder->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->utamahargalabelorder->cellAttributes() ?>>
<span id="el_npd_terms_utamahargalabelorder">
<input type="<?= $Page->utamahargalabelorder->getInputTextType() ?>" data-table="npd_terms" data-field="x_utamahargalabelorder" name="x_utamahargalabelorder" id="x_utamahargalabelorder" size="30" placeholder="<?= HtmlEncode($Page->utamahargalabelorder->getPlaceHolder()) ?>" value="<?= $Page->utamahargalabelorder->EditValue ?>"<?= $Page->utamahargalabelorder->editAttributes() ?> aria-describedby="x_utamahargalabelorder_help">
<?= $Page->utamahargalabelorder->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->utamahargalabelorder->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->utamahargatotalorder->Visible) { // utamahargatotalorder ?>
    <div id="r_utamahargatotalorder" class="form-group row">
        <label id="elh_npd_terms_utamahargatotalorder" for="x_utamahargatotalorder" class="<?= $Page->LeftColumnClass ?>"><?= $Page->utamahargatotalorder->caption() ?><?= $Page->utamahargatotalorder->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->utamahargatotalorder->cellAttributes() ?>>
<span id="el_npd_terms_utamahargatotalorder">
<input type="<?= $Page->utamahargatotalorder->getInputTextType() ?>" data-table="npd_terms" data-field="x_utamahargatotalorder" name="x_utamahargatotalorder" id="x_utamahargatotalorder" size="30" placeholder="<?= HtmlEncode($Page->utamahargatotalorder->getPlaceHolder()) ?>" value="<?= $Page->utamahargatotalorder->EditValue ?>"<?= $Page->utamahargatotalorder->editAttributes() ?> aria-describedby="x_utamahargatotalorder_help">
<?= $Page->utamahargatotalorder->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->utamahargatotalorder->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ukuranlain->Visible) { // ukuranlain ?>
    <div id="r_ukuranlain" class="form-group row">
        <label id="elh_npd_terms_ukuranlain" for="x_ukuranlain" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ukuranlain->caption() ?><?= $Page->ukuranlain->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ukuranlain->cellAttributes() ?>>
<span id="el_npd_terms_ukuranlain">
<input type="<?= $Page->ukuranlain->getInputTextType() ?>" data-table="npd_terms" data-field="x_ukuranlain" name="x_ukuranlain" id="x_ukuranlain" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->ukuranlain->getPlaceHolder()) ?>" value="<?= $Page->ukuranlain->EditValue ?>"<?= $Page->ukuranlain->editAttributes() ?> aria-describedby="x_ukuranlain_help">
<?= $Page->ukuranlain->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ukuranlain->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->lainhargaisipcs->Visible) { // lainhargaisipcs ?>
    <div id="r_lainhargaisipcs" class="form-group row">
        <label id="elh_npd_terms_lainhargaisipcs" for="x_lainhargaisipcs" class="<?= $Page->LeftColumnClass ?>"><?= $Page->lainhargaisipcs->caption() ?><?= $Page->lainhargaisipcs->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->lainhargaisipcs->cellAttributes() ?>>
<span id="el_npd_terms_lainhargaisipcs">
<input type="<?= $Page->lainhargaisipcs->getInputTextType() ?>" data-table="npd_terms" data-field="x_lainhargaisipcs" name="x_lainhargaisipcs" id="x_lainhargaisipcs" size="30" placeholder="<?= HtmlEncode($Page->lainhargaisipcs->getPlaceHolder()) ?>" value="<?= $Page->lainhargaisipcs->EditValue ?>"<?= $Page->lainhargaisipcs->editAttributes() ?> aria-describedby="x_lainhargaisipcs_help">
<?= $Page->lainhargaisipcs->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->lainhargaisipcs->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->lainhargaprimerpcs->Visible) { // lainhargaprimerpcs ?>
    <div id="r_lainhargaprimerpcs" class="form-group row">
        <label id="elh_npd_terms_lainhargaprimerpcs" for="x_lainhargaprimerpcs" class="<?= $Page->LeftColumnClass ?>"><?= $Page->lainhargaprimerpcs->caption() ?><?= $Page->lainhargaprimerpcs->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->lainhargaprimerpcs->cellAttributes() ?>>
<span id="el_npd_terms_lainhargaprimerpcs">
<input type="<?= $Page->lainhargaprimerpcs->getInputTextType() ?>" data-table="npd_terms" data-field="x_lainhargaprimerpcs" name="x_lainhargaprimerpcs" id="x_lainhargaprimerpcs" size="30" placeholder="<?= HtmlEncode($Page->lainhargaprimerpcs->getPlaceHolder()) ?>" value="<?= $Page->lainhargaprimerpcs->EditValue ?>"<?= $Page->lainhargaprimerpcs->editAttributes() ?> aria-describedby="x_lainhargaprimerpcs_help">
<?= $Page->lainhargaprimerpcs->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->lainhargaprimerpcs->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->lainhargasekunderpcs->Visible) { // lainhargasekunderpcs ?>
    <div id="r_lainhargasekunderpcs" class="form-group row">
        <label id="elh_npd_terms_lainhargasekunderpcs" for="x_lainhargasekunderpcs" class="<?= $Page->LeftColumnClass ?>"><?= $Page->lainhargasekunderpcs->caption() ?><?= $Page->lainhargasekunderpcs->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->lainhargasekunderpcs->cellAttributes() ?>>
<span id="el_npd_terms_lainhargasekunderpcs">
<input type="<?= $Page->lainhargasekunderpcs->getInputTextType() ?>" data-table="npd_terms" data-field="x_lainhargasekunderpcs" name="x_lainhargasekunderpcs" id="x_lainhargasekunderpcs" size="30" placeholder="<?= HtmlEncode($Page->lainhargasekunderpcs->getPlaceHolder()) ?>" value="<?= $Page->lainhargasekunderpcs->EditValue ?>"<?= $Page->lainhargasekunderpcs->editAttributes() ?> aria-describedby="x_lainhargasekunderpcs_help">
<?= $Page->lainhargasekunderpcs->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->lainhargasekunderpcs->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->lainhargalabelpcs->Visible) { // lainhargalabelpcs ?>
    <div id="r_lainhargalabelpcs" class="form-group row">
        <label id="elh_npd_terms_lainhargalabelpcs" for="x_lainhargalabelpcs" class="<?= $Page->LeftColumnClass ?>"><?= $Page->lainhargalabelpcs->caption() ?><?= $Page->lainhargalabelpcs->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->lainhargalabelpcs->cellAttributes() ?>>
<span id="el_npd_terms_lainhargalabelpcs">
<input type="<?= $Page->lainhargalabelpcs->getInputTextType() ?>" data-table="npd_terms" data-field="x_lainhargalabelpcs" name="x_lainhargalabelpcs" id="x_lainhargalabelpcs" size="30" placeholder="<?= HtmlEncode($Page->lainhargalabelpcs->getPlaceHolder()) ?>" value="<?= $Page->lainhargalabelpcs->EditValue ?>"<?= $Page->lainhargalabelpcs->editAttributes() ?> aria-describedby="x_lainhargalabelpcs_help">
<?= $Page->lainhargalabelpcs->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->lainhargalabelpcs->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->lainhargatotalpcs->Visible) { // lainhargatotalpcs ?>
    <div id="r_lainhargatotalpcs" class="form-group row">
        <label id="elh_npd_terms_lainhargatotalpcs" for="x_lainhargatotalpcs" class="<?= $Page->LeftColumnClass ?>"><?= $Page->lainhargatotalpcs->caption() ?><?= $Page->lainhargatotalpcs->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->lainhargatotalpcs->cellAttributes() ?>>
<span id="el_npd_terms_lainhargatotalpcs">
<input type="<?= $Page->lainhargatotalpcs->getInputTextType() ?>" data-table="npd_terms" data-field="x_lainhargatotalpcs" name="x_lainhargatotalpcs" id="x_lainhargatotalpcs" size="30" placeholder="<?= HtmlEncode($Page->lainhargatotalpcs->getPlaceHolder()) ?>" value="<?= $Page->lainhargatotalpcs->EditValue ?>"<?= $Page->lainhargatotalpcs->editAttributes() ?> aria-describedby="x_lainhargatotalpcs_help">
<?= $Page->lainhargatotalpcs->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->lainhargatotalpcs->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->lainhargaisiorder->Visible) { // lainhargaisiorder ?>
    <div id="r_lainhargaisiorder" class="form-group row">
        <label id="elh_npd_terms_lainhargaisiorder" for="x_lainhargaisiorder" class="<?= $Page->LeftColumnClass ?>"><?= $Page->lainhargaisiorder->caption() ?><?= $Page->lainhargaisiorder->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->lainhargaisiorder->cellAttributes() ?>>
<span id="el_npd_terms_lainhargaisiorder">
<input type="<?= $Page->lainhargaisiorder->getInputTextType() ?>" data-table="npd_terms" data-field="x_lainhargaisiorder" name="x_lainhargaisiorder" id="x_lainhargaisiorder" size="30" placeholder="<?= HtmlEncode($Page->lainhargaisiorder->getPlaceHolder()) ?>" value="<?= $Page->lainhargaisiorder->EditValue ?>"<?= $Page->lainhargaisiorder->editAttributes() ?> aria-describedby="x_lainhargaisiorder_help">
<?= $Page->lainhargaisiorder->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->lainhargaisiorder->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->lainhargaprimerorder->Visible) { // lainhargaprimerorder ?>
    <div id="r_lainhargaprimerorder" class="form-group row">
        <label id="elh_npd_terms_lainhargaprimerorder" for="x_lainhargaprimerorder" class="<?= $Page->LeftColumnClass ?>"><?= $Page->lainhargaprimerorder->caption() ?><?= $Page->lainhargaprimerorder->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->lainhargaprimerorder->cellAttributes() ?>>
<span id="el_npd_terms_lainhargaprimerorder">
<input type="<?= $Page->lainhargaprimerorder->getInputTextType() ?>" data-table="npd_terms" data-field="x_lainhargaprimerorder" name="x_lainhargaprimerorder" id="x_lainhargaprimerorder" size="30" placeholder="<?= HtmlEncode($Page->lainhargaprimerorder->getPlaceHolder()) ?>" value="<?= $Page->lainhargaprimerorder->EditValue ?>"<?= $Page->lainhargaprimerorder->editAttributes() ?> aria-describedby="x_lainhargaprimerorder_help">
<?= $Page->lainhargaprimerorder->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->lainhargaprimerorder->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->lainhargasekunderorder->Visible) { // lainhargasekunderorder ?>
    <div id="r_lainhargasekunderorder" class="form-group row">
        <label id="elh_npd_terms_lainhargasekunderorder" for="x_lainhargasekunderorder" class="<?= $Page->LeftColumnClass ?>"><?= $Page->lainhargasekunderorder->caption() ?><?= $Page->lainhargasekunderorder->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->lainhargasekunderorder->cellAttributes() ?>>
<span id="el_npd_terms_lainhargasekunderorder">
<input type="<?= $Page->lainhargasekunderorder->getInputTextType() ?>" data-table="npd_terms" data-field="x_lainhargasekunderorder" name="x_lainhargasekunderorder" id="x_lainhargasekunderorder" size="30" placeholder="<?= HtmlEncode($Page->lainhargasekunderorder->getPlaceHolder()) ?>" value="<?= $Page->lainhargasekunderorder->EditValue ?>"<?= $Page->lainhargasekunderorder->editAttributes() ?> aria-describedby="x_lainhargasekunderorder_help">
<?= $Page->lainhargasekunderorder->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->lainhargasekunderorder->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->lainhargalabelorder->Visible) { // lainhargalabelorder ?>
    <div id="r_lainhargalabelorder" class="form-group row">
        <label id="elh_npd_terms_lainhargalabelorder" for="x_lainhargalabelorder" class="<?= $Page->LeftColumnClass ?>"><?= $Page->lainhargalabelorder->caption() ?><?= $Page->lainhargalabelorder->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->lainhargalabelorder->cellAttributes() ?>>
<span id="el_npd_terms_lainhargalabelorder">
<input type="<?= $Page->lainhargalabelorder->getInputTextType() ?>" data-table="npd_terms" data-field="x_lainhargalabelorder" name="x_lainhargalabelorder" id="x_lainhargalabelorder" size="30" placeholder="<?= HtmlEncode($Page->lainhargalabelorder->getPlaceHolder()) ?>" value="<?= $Page->lainhargalabelorder->EditValue ?>"<?= $Page->lainhargalabelorder->editAttributes() ?> aria-describedby="x_lainhargalabelorder_help">
<?= $Page->lainhargalabelorder->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->lainhargalabelorder->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->lainhargatotalorder->Visible) { // lainhargatotalorder ?>
    <div id="r_lainhargatotalorder" class="form-group row">
        <label id="elh_npd_terms_lainhargatotalorder" for="x_lainhargatotalorder" class="<?= $Page->LeftColumnClass ?>"><?= $Page->lainhargatotalorder->caption() ?><?= $Page->lainhargatotalorder->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->lainhargatotalorder->cellAttributes() ?>>
<span id="el_npd_terms_lainhargatotalorder">
<input type="<?= $Page->lainhargatotalorder->getInputTextType() ?>" data-table="npd_terms" data-field="x_lainhargatotalorder" name="x_lainhargatotalorder" id="x_lainhargatotalorder" size="30" placeholder="<?= HtmlEncode($Page->lainhargatotalorder->getPlaceHolder()) ?>" value="<?= $Page->lainhargatotalorder->EditValue ?>"<?= $Page->lainhargatotalorder->editAttributes() ?> aria-describedby="x_lainhargatotalorder_help">
<?= $Page->lainhargatotalorder->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->lainhargatotalorder->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->isibahanaktif->Visible) { // isibahanaktif ?>
    <div id="r_isibahanaktif" class="form-group row">
        <label id="elh_npd_terms_isibahanaktif" for="x_isibahanaktif" class="<?= $Page->LeftColumnClass ?>"><?= $Page->isibahanaktif->caption() ?><?= $Page->isibahanaktif->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->isibahanaktif->cellAttributes() ?>>
<span id="el_npd_terms_isibahanaktif">
<input type="<?= $Page->isibahanaktif->getInputTextType() ?>" data-table="npd_terms" data-field="x_isibahanaktif" name="x_isibahanaktif" id="x_isibahanaktif" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->isibahanaktif->getPlaceHolder()) ?>" value="<?= $Page->isibahanaktif->EditValue ?>"<?= $Page->isibahanaktif->editAttributes() ?> aria-describedby="x_isibahanaktif_help">
<?= $Page->isibahanaktif->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->isibahanaktif->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->isibahanlain->Visible) { // isibahanlain ?>
    <div id="r_isibahanlain" class="form-group row">
        <label id="elh_npd_terms_isibahanlain" for="x_isibahanlain" class="<?= $Page->LeftColumnClass ?>"><?= $Page->isibahanlain->caption() ?><?= $Page->isibahanlain->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->isibahanlain->cellAttributes() ?>>
<span id="el_npd_terms_isibahanlain">
<input type="<?= $Page->isibahanlain->getInputTextType() ?>" data-table="npd_terms" data-field="x_isibahanlain" name="x_isibahanlain" id="x_isibahanlain" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->isibahanlain->getPlaceHolder()) ?>" value="<?= $Page->isibahanlain->EditValue ?>"<?= $Page->isibahanlain->editAttributes() ?> aria-describedby="x_isibahanlain_help">
<?= $Page->isibahanlain->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->isibahanlain->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->isiparfum->Visible) { // isiparfum ?>
    <div id="r_isiparfum" class="form-group row">
        <label id="elh_npd_terms_isiparfum" for="x_isiparfum" class="<?= $Page->LeftColumnClass ?>"><?= $Page->isiparfum->caption() ?><?= $Page->isiparfum->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->isiparfum->cellAttributes() ?>>
<span id="el_npd_terms_isiparfum">
<input type="<?= $Page->isiparfum->getInputTextType() ?>" data-table="npd_terms" data-field="x_isiparfum" name="x_isiparfum" id="x_isiparfum" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->isiparfum->getPlaceHolder()) ?>" value="<?= $Page->isiparfum->EditValue ?>"<?= $Page->isiparfum->editAttributes() ?> aria-describedby="x_isiparfum_help">
<?= $Page->isiparfum->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->isiparfum->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->isiestetika->Visible) { // isiestetika ?>
    <div id="r_isiestetika" class="form-group row">
        <label id="elh_npd_terms_isiestetika" for="x_isiestetika" class="<?= $Page->LeftColumnClass ?>"><?= $Page->isiestetika->caption() ?><?= $Page->isiestetika->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->isiestetika->cellAttributes() ?>>
<span id="el_npd_terms_isiestetika">
<input type="<?= $Page->isiestetika->getInputTextType() ?>" data-table="npd_terms" data-field="x_isiestetika" name="x_isiestetika" id="x_isiestetika" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->isiestetika->getPlaceHolder()) ?>" value="<?= $Page->isiestetika->EditValue ?>"<?= $Page->isiestetika->editAttributes() ?> aria-describedby="x_isiestetika_help">
<?= $Page->isiestetika->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->isiestetika->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kemasanwadah->Visible) { // kemasanwadah ?>
    <div id="r_kemasanwadah" class="form-group row">
        <label id="elh_npd_terms_kemasanwadah" for="x_kemasanwadah" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kemasanwadah->caption() ?><?= $Page->kemasanwadah->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kemasanwadah->cellAttributes() ?>>
<span id="el_npd_terms_kemasanwadah">
<input type="<?= $Page->kemasanwadah->getInputTextType() ?>" data-table="npd_terms" data-field="x_kemasanwadah" name="x_kemasanwadah" id="x_kemasanwadah" size="30" placeholder="<?= HtmlEncode($Page->kemasanwadah->getPlaceHolder()) ?>" value="<?= $Page->kemasanwadah->EditValue ?>"<?= $Page->kemasanwadah->editAttributes() ?> aria-describedby="x_kemasanwadah_help">
<?= $Page->kemasanwadah->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kemasanwadah->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kemasantutup->Visible) { // kemasantutup ?>
    <div id="r_kemasantutup" class="form-group row">
        <label id="elh_npd_terms_kemasantutup" for="x_kemasantutup" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kemasantutup->caption() ?><?= $Page->kemasantutup->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kemasantutup->cellAttributes() ?>>
<span id="el_npd_terms_kemasantutup">
<input type="<?= $Page->kemasantutup->getInputTextType() ?>" data-table="npd_terms" data-field="x_kemasantutup" name="x_kemasantutup" id="x_kemasantutup" size="30" placeholder="<?= HtmlEncode($Page->kemasantutup->getPlaceHolder()) ?>" value="<?= $Page->kemasantutup->EditValue ?>"<?= $Page->kemasantutup->editAttributes() ?> aria-describedby="x_kemasantutup_help">
<?= $Page->kemasantutup->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kemasantutup->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kemasansekunder->Visible) { // kemasansekunder ?>
    <div id="r_kemasansekunder" class="form-group row">
        <label id="elh_npd_terms_kemasansekunder" for="x_kemasansekunder" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kemasansekunder->caption() ?><?= $Page->kemasansekunder->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kemasansekunder->cellAttributes() ?>>
<span id="el_npd_terms_kemasansekunder">
<input type="<?= $Page->kemasansekunder->getInputTextType() ?>" data-table="npd_terms" data-field="x_kemasansekunder" name="x_kemasansekunder" id="x_kemasansekunder" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->kemasansekunder->getPlaceHolder()) ?>" value="<?= $Page->kemasansekunder->EditValue ?>"<?= $Page->kemasansekunder->editAttributes() ?> aria-describedby="x_kemasansekunder_help">
<?= $Page->kemasansekunder->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kemasansekunder->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->desainlabel->Visible) { // desainlabel ?>
    <div id="r_desainlabel" class="form-group row">
        <label id="elh_npd_terms_desainlabel" for="x_desainlabel" class="<?= $Page->LeftColumnClass ?>"><?= $Page->desainlabel->caption() ?><?= $Page->desainlabel->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->desainlabel->cellAttributes() ?>>
<span id="el_npd_terms_desainlabel">
<input type="<?= $Page->desainlabel->getInputTextType() ?>" data-table="npd_terms" data-field="x_desainlabel" name="x_desainlabel" id="x_desainlabel" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->desainlabel->getPlaceHolder()) ?>" value="<?= $Page->desainlabel->EditValue ?>"<?= $Page->desainlabel->editAttributes() ?> aria-describedby="x_desainlabel_help">
<?= $Page->desainlabel->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->desainlabel->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cetaklabel->Visible) { // cetaklabel ?>
    <div id="r_cetaklabel" class="form-group row">
        <label id="elh_npd_terms_cetaklabel" for="x_cetaklabel" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cetaklabel->caption() ?><?= $Page->cetaklabel->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->cetaklabel->cellAttributes() ?>>
<span id="el_npd_terms_cetaklabel">
<input type="<?= $Page->cetaklabel->getInputTextType() ?>" data-table="npd_terms" data-field="x_cetaklabel" name="x_cetaklabel" id="x_cetaklabel" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->cetaklabel->getPlaceHolder()) ?>" value="<?= $Page->cetaklabel->EditValue ?>"<?= $Page->cetaklabel->editAttributes() ?> aria-describedby="x_cetaklabel_help">
<?= $Page->cetaklabel->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cetaklabel->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->lainlain->Visible) { // lainlain ?>
    <div id="r_lainlain" class="form-group row">
        <label id="elh_npd_terms_lainlain" for="x_lainlain" class="<?= $Page->LeftColumnClass ?>"><?= $Page->lainlain->caption() ?><?= $Page->lainlain->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->lainlain->cellAttributes() ?>>
<span id="el_npd_terms_lainlain">
<input type="<?= $Page->lainlain->getInputTextType() ?>" data-table="npd_terms" data-field="x_lainlain" name="x_lainlain" id="x_lainlain" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->lainlain->getPlaceHolder()) ?>" value="<?= $Page->lainlain->EditValue ?>"<?= $Page->lainlain->editAttributes() ?> aria-describedby="x_lainlain_help">
<?= $Page->lainlain->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->lainlain->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->deliverypickup->Visible) { // deliverypickup ?>
    <div id="r_deliverypickup" class="form-group row">
        <label id="elh_npd_terms_deliverypickup" for="x_deliverypickup" class="<?= $Page->LeftColumnClass ?>"><?= $Page->deliverypickup->caption() ?><?= $Page->deliverypickup->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->deliverypickup->cellAttributes() ?>>
<span id="el_npd_terms_deliverypickup">
<input type="<?= $Page->deliverypickup->getInputTextType() ?>" data-table="npd_terms" data-field="x_deliverypickup" name="x_deliverypickup" id="x_deliverypickup" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->deliverypickup->getPlaceHolder()) ?>" value="<?= $Page->deliverypickup->EditValue ?>"<?= $Page->deliverypickup->editAttributes() ?> aria-describedby="x_deliverypickup_help">
<?= $Page->deliverypickup->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->deliverypickup->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->deliverysinglepoint->Visible) { // deliverysinglepoint ?>
    <div id="r_deliverysinglepoint" class="form-group row">
        <label id="elh_npd_terms_deliverysinglepoint" for="x_deliverysinglepoint" class="<?= $Page->LeftColumnClass ?>"><?= $Page->deliverysinglepoint->caption() ?><?= $Page->deliverysinglepoint->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->deliverysinglepoint->cellAttributes() ?>>
<span id="el_npd_terms_deliverysinglepoint">
<input type="<?= $Page->deliverysinglepoint->getInputTextType() ?>" data-table="npd_terms" data-field="x_deliverysinglepoint" name="x_deliverysinglepoint" id="x_deliverysinglepoint" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->deliverysinglepoint->getPlaceHolder()) ?>" value="<?= $Page->deliverysinglepoint->EditValue ?>"<?= $Page->deliverysinglepoint->editAttributes() ?> aria-describedby="x_deliverysinglepoint_help">
<?= $Page->deliverysinglepoint->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->deliverysinglepoint->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->deliverymultipoint->Visible) { // deliverymultipoint ?>
    <div id="r_deliverymultipoint" class="form-group row">
        <label id="elh_npd_terms_deliverymultipoint" for="x_deliverymultipoint" class="<?= $Page->LeftColumnClass ?>"><?= $Page->deliverymultipoint->caption() ?><?= $Page->deliverymultipoint->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->deliverymultipoint->cellAttributes() ?>>
<span id="el_npd_terms_deliverymultipoint">
<input type="<?= $Page->deliverymultipoint->getInputTextType() ?>" data-table="npd_terms" data-field="x_deliverymultipoint" name="x_deliverymultipoint" id="x_deliverymultipoint" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->deliverymultipoint->getPlaceHolder()) ?>" value="<?= $Page->deliverymultipoint->EditValue ?>"<?= $Page->deliverymultipoint->editAttributes() ?> aria-describedby="x_deliverymultipoint_help">
<?= $Page->deliverymultipoint->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->deliverymultipoint->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->deliveryjumlahpoint->Visible) { // deliveryjumlahpoint ?>
    <div id="r_deliveryjumlahpoint" class="form-group row">
        <label id="elh_npd_terms_deliveryjumlahpoint" for="x_deliveryjumlahpoint" class="<?= $Page->LeftColumnClass ?>"><?= $Page->deliveryjumlahpoint->caption() ?><?= $Page->deliveryjumlahpoint->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->deliveryjumlahpoint->cellAttributes() ?>>
<span id="el_npd_terms_deliveryjumlahpoint">
<input type="<?= $Page->deliveryjumlahpoint->getInputTextType() ?>" data-table="npd_terms" data-field="x_deliveryjumlahpoint" name="x_deliveryjumlahpoint" id="x_deliveryjumlahpoint" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->deliveryjumlahpoint->getPlaceHolder()) ?>" value="<?= $Page->deliveryjumlahpoint->EditValue ?>"<?= $Page->deliveryjumlahpoint->editAttributes() ?> aria-describedby="x_deliveryjumlahpoint_help">
<?= $Page->deliveryjumlahpoint->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->deliveryjumlahpoint->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->deliverytermslain->Visible) { // deliverytermslain ?>
    <div id="r_deliverytermslain" class="form-group row">
        <label id="elh_npd_terms_deliverytermslain" for="x_deliverytermslain" class="<?= $Page->LeftColumnClass ?>"><?= $Page->deliverytermslain->caption() ?><?= $Page->deliverytermslain->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->deliverytermslain->cellAttributes() ?>>
<span id="el_npd_terms_deliverytermslain">
<input type="<?= $Page->deliverytermslain->getInputTextType() ?>" data-table="npd_terms" data-field="x_deliverytermslain" name="x_deliverytermslain" id="x_deliverytermslain" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->deliverytermslain->getPlaceHolder()) ?>" value="<?= $Page->deliverytermslain->EditValue ?>"<?= $Page->deliverytermslain->editAttributes() ?> aria-describedby="x_deliverytermslain_help">
<?= $Page->deliverytermslain->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->deliverytermslain->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->catatankhusus->Visible) { // catatankhusus ?>
    <div id="r_catatankhusus" class="form-group row">
        <label id="elh_npd_terms_catatankhusus" for="x_catatankhusus" class="<?= $Page->LeftColumnClass ?>"><?= $Page->catatankhusus->caption() ?><?= $Page->catatankhusus->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->catatankhusus->cellAttributes() ?>>
<span id="el_npd_terms_catatankhusus">
<input type="<?= $Page->catatankhusus->getInputTextType() ?>" data-table="npd_terms" data-field="x_catatankhusus" name="x_catatankhusus" id="x_catatankhusus" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->catatankhusus->getPlaceHolder()) ?>" value="<?= $Page->catatankhusus->EditValue ?>"<?= $Page->catatankhusus->editAttributes() ?> aria-describedby="x_catatankhusus_help">
<?= $Page->catatankhusus->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->catatankhusus->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->dibuatdi->Visible) { // dibuatdi ?>
    <div id="r_dibuatdi" class="form-group row">
        <label id="elh_npd_terms_dibuatdi" for="x_dibuatdi" class="<?= $Page->LeftColumnClass ?>"><?= $Page->dibuatdi->caption() ?><?= $Page->dibuatdi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->dibuatdi->cellAttributes() ?>>
<span id="el_npd_terms_dibuatdi">
<input type="<?= $Page->dibuatdi->getInputTextType() ?>" data-table="npd_terms" data-field="x_dibuatdi" name="x_dibuatdi" id="x_dibuatdi" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->dibuatdi->getPlaceHolder()) ?>" value="<?= $Page->dibuatdi->EditValue ?>"<?= $Page->dibuatdi->editAttributes() ?> aria-describedby="x_dibuatdi_help">
<?= $Page->dibuatdi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->dibuatdi->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tanggal->Visible) { // tanggal ?>
    <div id="r_tanggal" class="form-group row">
        <label id="elh_npd_terms_tanggal" for="x_tanggal" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tanggal->caption() ?><?= $Page->tanggal->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tanggal->cellAttributes() ?>>
<span id="el_npd_terms_tanggal">
<input type="<?= $Page->tanggal->getInputTextType() ?>" data-table="npd_terms" data-field="x_tanggal" name="x_tanggal" id="x_tanggal" placeholder="<?= HtmlEncode($Page->tanggal->getPlaceHolder()) ?>" value="<?= $Page->tanggal->EditValue ?>"<?= $Page->tanggal->editAttributes() ?> aria-describedby="x_tanggal_help">
<?= $Page->tanggal->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tanggal->getErrorMessage() ?></div>
<?php if (!$Page->tanggal->ReadOnly && !$Page->tanggal->Disabled && !isset($Page->tanggal->EditAttrs["readonly"]) && !isset($Page->tanggal->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_termsedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_termsedit", "x_tanggal", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->created_by->Visible) { // created_by ?>
    <div id="r_created_by" class="form-group row">
        <label id="elh_npd_terms_created_by" for="x_created_by" class="<?= $Page->LeftColumnClass ?>"><?= $Page->created_by->caption() ?><?= $Page->created_by->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->created_by->cellAttributes() ?>>
<span id="el_npd_terms_created_by">
<input type="<?= $Page->created_by->getInputTextType() ?>" data-table="npd_terms" data-field="x_created_by" name="x_created_by" id="x_created_by" size="30" placeholder="<?= HtmlEncode($Page->created_by->getPlaceHolder()) ?>" value="<?= $Page->created_by->EditValue ?>"<?= $Page->created_by->editAttributes() ?> aria-describedby="x_created_by_help">
<?= $Page->created_by->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->created_by->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
    </div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("npd_terms");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>

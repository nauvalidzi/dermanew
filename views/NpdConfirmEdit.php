<?php

namespace PHPMaker2021\Dermateknonew;

// Page object
$NpdConfirmEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fnpd_confirmedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fnpd_confirmedit = currentForm = new ew.Form("fnpd_confirmedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "npd_confirm")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.npd_confirm)
        ew.vars.tables.npd_confirm = currentTable;
    fnpd_confirmedit.addFields([
        ["tglkonfirmasi", [fields.tglkonfirmasi.visible && fields.tglkonfirmasi.required ? ew.Validators.required(fields.tglkonfirmasi.caption) : null, ew.Validators.datetime(0)], fields.tglkonfirmasi.isInvalid],
        ["foto", [fields.foto.visible && fields.foto.required ? ew.Validators.fileRequired(fields.foto.caption) : null], fields.foto.isInvalid],
        ["namapemesan", [fields.namapemesan.visible && fields.namapemesan.required ? ew.Validators.required(fields.namapemesan.caption) : null], fields.namapemesan.isInvalid],
        ["alamatpemesan", [fields.alamatpemesan.visible && fields.alamatpemesan.required ? ew.Validators.required(fields.alamatpemesan.caption) : null], fields.alamatpemesan.isInvalid],
        ["personincharge", [fields.personincharge.visible && fields.personincharge.required ? ew.Validators.required(fields.personincharge.caption) : null], fields.personincharge.isInvalid],
        ["jabatan", [fields.jabatan.visible && fields.jabatan.required ? ew.Validators.required(fields.jabatan.caption) : null], fields.jabatan.isInvalid],
        ["notelp", [fields.notelp.visible && fields.notelp.required ? ew.Validators.required(fields.notelp.caption) : null], fields.notelp.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fnpd_confirmedit,
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
    fnpd_confirmedit.validate = function () {
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
    fnpd_confirmedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fnpd_confirmedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fnpd_confirmedit");
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
<form name="fnpd_confirmedit" id="fnpd_confirmedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_confirm">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "npd") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="npd">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->idnpd->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->tglkonfirmasi->Visible) { // tglkonfirmasi ?>
    <div id="r_tglkonfirmasi" class="form-group row">
        <label id="elh_npd_confirm_tglkonfirmasi" for="x_tglkonfirmasi" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tglkonfirmasi->caption() ?><?= $Page->tglkonfirmasi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tglkonfirmasi->cellAttributes() ?>>
<span id="el_npd_confirm_tglkonfirmasi">
<input type="<?= $Page->tglkonfirmasi->getInputTextType() ?>" data-table="npd_confirm" data-field="x_tglkonfirmasi" name="x_tglkonfirmasi" id="x_tglkonfirmasi" placeholder="<?= HtmlEncode($Page->tglkonfirmasi->getPlaceHolder()) ?>" value="<?= $Page->tglkonfirmasi->EditValue ?>"<?= $Page->tglkonfirmasi->editAttributes() ?> aria-describedby="x_tglkonfirmasi_help">
<?= $Page->tglkonfirmasi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tglkonfirmasi->getErrorMessage() ?></div>
<?php if (!$Page->tglkonfirmasi->ReadOnly && !$Page->tglkonfirmasi->Disabled && !isset($Page->tglkonfirmasi->EditAttrs["readonly"]) && !isset($Page->tglkonfirmasi->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_confirmedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_confirmedit", "x_tglkonfirmasi", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->foto->Visible) { // foto ?>
    <div id="r_foto" class="form-group row">
        <label id="elh_npd_confirm_foto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->foto->caption() ?><?= $Page->foto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->foto->cellAttributes() ?>>
<span id="el_npd_confirm_foto">
<div id="fd_x_foto">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->foto->title() ?>" data-table="npd_confirm" data-field="x_foto" name="x_foto" id="x_foto" lang="<?= CurrentLanguageID() ?>"<?= $Page->foto->editAttributes() ?><?= ($Page->foto->ReadOnly || $Page->foto->Disabled) ? " disabled" : "" ?> aria-describedby="x_foto_help">
        <label class="custom-file-label ew-file-label" for="x_foto"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<?= $Page->foto->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->foto->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_foto" id= "fn_x_foto" value="<?= $Page->foto->Upload->FileName ?>">
<input type="hidden" name="fa_x_foto" id= "fa_x_foto" value="<?= (Post("fa_x_foto") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x_foto" id= "fs_x_foto" value="255">
<input type="hidden" name="fx_x_foto" id= "fx_x_foto" value="<?= $Page->foto->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_foto" id= "fm_x_foto" value="<?= $Page->foto->UploadMaxFileSize ?>">
</div>
<table id="ft_x_foto" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->namapemesan->Visible) { // namapemesan ?>
    <div id="r_namapemesan" class="form-group row">
        <label id="elh_npd_confirm_namapemesan" for="x_namapemesan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->namapemesan->caption() ?><?= $Page->namapemesan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->namapemesan->cellAttributes() ?>>
<span id="el_npd_confirm_namapemesan">
<input type="<?= $Page->namapemesan->getInputTextType() ?>" data-table="npd_confirm" data-field="x_namapemesan" name="x_namapemesan" id="x_namapemesan" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->namapemesan->getPlaceHolder()) ?>" value="<?= $Page->namapemesan->EditValue ?>"<?= $Page->namapemesan->editAttributes() ?> aria-describedby="x_namapemesan_help">
<?= $Page->namapemesan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->namapemesan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->alamatpemesan->Visible) { // alamatpemesan ?>
    <div id="r_alamatpemesan" class="form-group row">
        <label id="elh_npd_confirm_alamatpemesan" for="x_alamatpemesan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->alamatpemesan->caption() ?><?= $Page->alamatpemesan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->alamatpemesan->cellAttributes() ?>>
<span id="el_npd_confirm_alamatpemesan">
<input type="<?= $Page->alamatpemesan->getInputTextType() ?>" data-table="npd_confirm" data-field="x_alamatpemesan" name="x_alamatpemesan" id="x_alamatpemesan" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->alamatpemesan->getPlaceHolder()) ?>" value="<?= $Page->alamatpemesan->EditValue ?>"<?= $Page->alamatpemesan->editAttributes() ?> aria-describedby="x_alamatpemesan_help">
<?= $Page->alamatpemesan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->alamatpemesan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->personincharge->Visible) { // personincharge ?>
    <div id="r_personincharge" class="form-group row">
        <label id="elh_npd_confirm_personincharge" for="x_personincharge" class="<?= $Page->LeftColumnClass ?>"><?= $Page->personincharge->caption() ?><?= $Page->personincharge->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->personincharge->cellAttributes() ?>>
<span id="el_npd_confirm_personincharge">
<input type="<?= $Page->personincharge->getInputTextType() ?>" data-table="npd_confirm" data-field="x_personincharge" name="x_personincharge" id="x_personincharge" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->personincharge->getPlaceHolder()) ?>" value="<?= $Page->personincharge->EditValue ?>"<?= $Page->personincharge->editAttributes() ?> aria-describedby="x_personincharge_help">
<?= $Page->personincharge->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->personincharge->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->jabatan->Visible) { // jabatan ?>
    <div id="r_jabatan" class="form-group row">
        <label id="elh_npd_confirm_jabatan" for="x_jabatan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->jabatan->caption() ?><?= $Page->jabatan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->jabatan->cellAttributes() ?>>
<span id="el_npd_confirm_jabatan">
<input type="<?= $Page->jabatan->getInputTextType() ?>" data-table="npd_confirm" data-field="x_jabatan" name="x_jabatan" id="x_jabatan" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->jabatan->getPlaceHolder()) ?>" value="<?= $Page->jabatan->EditValue ?>"<?= $Page->jabatan->editAttributes() ?> aria-describedby="x_jabatan_help">
<?= $Page->jabatan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->jabatan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->notelp->Visible) { // notelp ?>
    <div id="r_notelp" class="form-group row">
        <label id="elh_npd_confirm_notelp" for="x_notelp" class="<?= $Page->LeftColumnClass ?>"><?= $Page->notelp->caption() ?><?= $Page->notelp->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->notelp->cellAttributes() ?>>
<span id="el_npd_confirm_notelp">
<input type="<?= $Page->notelp->getInputTextType() ?>" data-table="npd_confirm" data-field="x_notelp" name="x_notelp" id="x_notelp" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->notelp->getPlaceHolder()) ?>" value="<?= $Page->notelp->EditValue ?>"<?= $Page->notelp->editAttributes() ?> aria-describedby="x_notelp_help">
<?= $Page->notelp->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->notelp->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="npd_confirm" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
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
    ew.addEventHandlers("npd_confirm");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    loadjs.ready("jquery",(function(){$("#r_namapemesan").before('<h5 class="form-group">Data Pemesan</h5>')}));
});
</script>

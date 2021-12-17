<?php

namespace PHPMaker2021\Dermateknonew;

// Page object
$TitipmerkValidasiEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var ftitipmerk_validasiedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    ftitipmerk_validasiedit = currentForm = new ew.Form("ftitipmerk_validasiedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "titipmerk_validasi")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.titipmerk_validasi)
        ew.vars.tables.titipmerk_validasi = currentTable;
    ftitipmerk_validasiedit.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["idm_titipmerk", [fields.idm_titipmerk.visible && fields.idm_titipmerk.required ? ew.Validators.required(fields.idm_titipmerk.caption) : null, ew.Validators.integer], fields.idm_titipmerk.isInvalid],
        ["validator", [fields.validator.visible && fields.validator.required ? ew.Validators.required(fields.validator.caption) : null], fields.validator.isInvalid],
        ["tanggal", [fields.tanggal.visible && fields.tanggal.required ? ew.Validators.required(fields.tanggal.caption) : null, ew.Validators.datetime(0)], fields.tanggal.isInvalid],
        ["valid", [fields.valid.visible && fields.valid.required ? ew.Validators.required(fields.valid.caption) : null], fields.valid.isInvalid],
        ["created_at", [fields.created_at.visible && fields.created_at.required ? ew.Validators.required(fields.created_at.caption) : null, ew.Validators.datetime(0)], fields.created_at.isInvalid],
        ["created_by", [fields.created_by.visible && fields.created_by.required ? ew.Validators.required(fields.created_by.caption) : null, ew.Validators.integer], fields.created_by.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = ftitipmerk_validasiedit,
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
    ftitipmerk_validasiedit.validate = function () {
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
    ftitipmerk_validasiedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ftitipmerk_validasiedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    ftitipmerk_validasiedit.lists.valid = <?= $Page->valid->toClientList($Page) ?>;
    loadjs.done("ftitipmerk_validasiedit");
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
<form name="ftitipmerk_validasiedit" id="ftitipmerk_validasiedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="titipmerk_validasi">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id" class="form-group row">
        <label id="elh_titipmerk_validasi_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id->cellAttributes() ?>>
<span id="el_titipmerk_validasi_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="titipmerk_validasi" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idm_titipmerk->Visible) { // idm_titipmerk ?>
    <div id="r_idm_titipmerk" class="form-group row">
        <label id="elh_titipmerk_validasi_idm_titipmerk" for="x_idm_titipmerk" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idm_titipmerk->caption() ?><?= $Page->idm_titipmerk->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idm_titipmerk->cellAttributes() ?>>
<span id="el_titipmerk_validasi_idm_titipmerk">
<input type="<?= $Page->idm_titipmerk->getInputTextType() ?>" data-table="titipmerk_validasi" data-field="x_idm_titipmerk" name="x_idm_titipmerk" id="x_idm_titipmerk" size="30" placeholder="<?= HtmlEncode($Page->idm_titipmerk->getPlaceHolder()) ?>" value="<?= $Page->idm_titipmerk->EditValue ?>"<?= $Page->idm_titipmerk->editAttributes() ?> aria-describedby="x_idm_titipmerk_help">
<?= $Page->idm_titipmerk->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->idm_titipmerk->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->validator->Visible) { // validator ?>
    <div id="r_validator" class="form-group row">
        <label id="elh_titipmerk_validasi_validator" for="x_validator" class="<?= $Page->LeftColumnClass ?>"><?= $Page->validator->caption() ?><?= $Page->validator->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->validator->cellAttributes() ?>>
<span id="el_titipmerk_validasi_validator">
<input type="<?= $Page->validator->getInputTextType() ?>" data-table="titipmerk_validasi" data-field="x_validator" name="x_validator" id="x_validator" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->validator->getPlaceHolder()) ?>" value="<?= $Page->validator->EditValue ?>"<?= $Page->validator->editAttributes() ?> aria-describedby="x_validator_help">
<?= $Page->validator->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->validator->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tanggal->Visible) { // tanggal ?>
    <div id="r_tanggal" class="form-group row">
        <label id="elh_titipmerk_validasi_tanggal" for="x_tanggal" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tanggal->caption() ?><?= $Page->tanggal->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tanggal->cellAttributes() ?>>
<span id="el_titipmerk_validasi_tanggal">
<input type="<?= $Page->tanggal->getInputTextType() ?>" data-table="titipmerk_validasi" data-field="x_tanggal" name="x_tanggal" id="x_tanggal" placeholder="<?= HtmlEncode($Page->tanggal->getPlaceHolder()) ?>" value="<?= $Page->tanggal->EditValue ?>"<?= $Page->tanggal->editAttributes() ?> aria-describedby="x_tanggal_help">
<?= $Page->tanggal->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tanggal->getErrorMessage() ?></div>
<?php if (!$Page->tanggal->ReadOnly && !$Page->tanggal->Disabled && !isset($Page->tanggal->EditAttrs["readonly"]) && !isset($Page->tanggal->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ftitipmerk_validasiedit", "datetimepicker"], function() {
    ew.createDateTimePicker("ftitipmerk_validasiedit", "x_tanggal", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->valid->Visible) { // valid ?>
    <div id="r_valid" class="form-group row">
        <label id="elh_titipmerk_validasi_valid" class="<?= $Page->LeftColumnClass ?>"><?= $Page->valid->caption() ?><?= $Page->valid->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->valid->cellAttributes() ?>>
<span id="el_titipmerk_validasi_valid">
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" class="custom-control-input<?= $Page->valid->isInvalidClass() ?>" data-table="titipmerk_validasi" data-field="x_valid" name="x_valid[]" id="x_valid_808085" value="1"<?= ConvertToBool($Page->valid->CurrentValue) ? " checked" : "" ?><?= $Page->valid->editAttributes() ?> aria-describedby="x_valid_help">
    <label class="custom-control-label" for="x_valid_808085"></label>
</div>
<?= $Page->valid->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->valid->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <div id="r_created_at" class="form-group row">
        <label id="elh_titipmerk_validasi_created_at" for="x_created_at" class="<?= $Page->LeftColumnClass ?>"><?= $Page->created_at->caption() ?><?= $Page->created_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->created_at->cellAttributes() ?>>
<span id="el_titipmerk_validasi_created_at">
<input type="<?= $Page->created_at->getInputTextType() ?>" data-table="titipmerk_validasi" data-field="x_created_at" name="x_created_at" id="x_created_at" placeholder="<?= HtmlEncode($Page->created_at->getPlaceHolder()) ?>" value="<?= $Page->created_at->EditValue ?>"<?= $Page->created_at->editAttributes() ?> aria-describedby="x_created_at_help">
<?= $Page->created_at->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->created_at->getErrorMessage() ?></div>
<?php if (!$Page->created_at->ReadOnly && !$Page->created_at->Disabled && !isset($Page->created_at->EditAttrs["readonly"]) && !isset($Page->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ftitipmerk_validasiedit", "datetimepicker"], function() {
    ew.createDateTimePicker("ftitipmerk_validasiedit", "x_created_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->created_by->Visible) { // created_by ?>
    <div id="r_created_by" class="form-group row">
        <label id="elh_titipmerk_validasi_created_by" for="x_created_by" class="<?= $Page->LeftColumnClass ?>"><?= $Page->created_by->caption() ?><?= $Page->created_by->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->created_by->cellAttributes() ?>>
<span id="el_titipmerk_validasi_created_by">
<input type="<?= $Page->created_by->getInputTextType() ?>" data-table="titipmerk_validasi" data-field="x_created_by" name="x_created_by" id="x_created_by" size="30" placeholder="<?= HtmlEncode($Page->created_by->getPlaceHolder()) ?>" value="<?= $Page->created_by->EditValue ?>"<?= $Page->created_by->editAttributes() ?> aria-describedby="x_created_by_help">
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
    ew.addEventHandlers("titipmerk_validasi");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>

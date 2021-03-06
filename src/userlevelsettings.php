<?php
/**
 * PHPMaker 2021 user level settings
 */
namespace PHPMaker2021\Dermateknonew;

// User level info
$USER_LEVELS = [["-2","Anonymous"],
    ["0","Default"],
    ["1","Marketing"]];
// User level priv info
$USER_LEVEL_PRIVS = [["{E0FDE1D0-889A-402F-A577-286E80B13C3A}pegawai","-2","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}pegawai","0","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}pegawai","1","301"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}userlevelpermissions","-2","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}userlevelpermissions","0","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}userlevelpermissions","1","64"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}userlevels","-2","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}userlevels","0","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}userlevels","1","64"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}customer","-2","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}customer","0","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}customer","1","367"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}alamat_customer","-2","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}alamat_customer","0","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}alamat_customer","1","367"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}tipecustomer","-2","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}tipecustomer","0","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}tipecustomer","1","352"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}brand","-2","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}brand","0","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}brand","1","367"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}provinsi","-2","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}provinsi","0","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}provinsi","1","352"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}kabupaten","-2","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}kabupaten","0","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}kabupaten","1","352"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}kecamatan","-2","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}kecamatan","0","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}kecamatan","1","352"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}kelurahan","-2","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}kelurahan","0","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}kelurahan","1","352"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}product","-2","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}product","0","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}product","1","352"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}d_jatuhtempo","-2","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}d_jatuhtempo","0","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}d_jatuhtempo","1","367"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}kategoribarang","-2","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}kategoribarang","0","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}kategoribarang","1","360"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}jenisbarang","-2","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}jenisbarang","0","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}jenisbarang","1","360"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}kemasanbarang","-2","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}kemasanbarang","0","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}kemasanbarang","1","360"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}kualitasbarang","-2","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}kualitasbarang","0","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}kualitasbarang","1","360"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}aplikasibarang","-2","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}aplikasibarang","0","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}aplikasibarang","1","360"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}viskositasbarang","-2","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}viskositasbarang","0","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}viskositasbarang","1","360"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}ekspedisi","-2","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}ekspedisi","0","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}ekspedisi","1","361"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}rekening","-2","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}rekening","0","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}rekening","1","352"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}satuan","-2","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}satuan","0","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}satuan","1","352"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}npd","-2","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}npd","0","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}npd","1","367"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}npd_terms","-2","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}npd_terms","0","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}npd_terms","1","367"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}npd_status","-2","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}npd_status","0","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}npd_status","1","367"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}npd_sample","-2","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}npd_sample","0","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}npd_sample","1","367"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}npd_review","-2","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}npd_review","0","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}npd_review","1","367"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}npd_extend","-2","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}npd_extend","0","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}npd_extend","1","367"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}npd_confirm","-2","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}npd_confirm","0","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}npd_confirm","1","367"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}npd_harga","-2","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}npd_harga","0","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}npd_harga","1","367"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}serahterima","-2","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}serahterima","0","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}serahterima","1","367"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}ijinhaki","-2","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}ijinhaki","0","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}ijinhaki","1","367"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}ijinhaki_status","-2","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}ijinhaki_status","0","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}ijinhaki_status","1","367"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}ijinbpom","-2","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}ijinbpom","0","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}ijinbpom","1","367"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}ijinbpom_detail","-2","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}ijinbpom_detail","0","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}ijinbpom_detail","1","367"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}ijinbpom_status","-2","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}ijinbpom_status","0","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}ijinbpom_status","1","367"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}order","-2","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}order","0","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}order","1","367"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}order_detail","-2","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}order_detail","0","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}order_detail","1","367"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}deliveryorder","-2","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}deliveryorder","0","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}deliveryorder","1","367"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}deliveryorder_detail","-2","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}deliveryorder_detail","0","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}deliveryorder_detail","1","367"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}invoice","-2","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}invoice","0","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}invoice","1","367"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}invoice_detail","-2","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}invoice_detail","0","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}invoice_detail","1","367"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}suratjalan","-2","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}suratjalan","0","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}suratjalan","1","367"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}suratjalan_detail","-2","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}suratjalan_detail","0","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}suratjalan_detail","1","367"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}pembayaran","-2","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}pembayaran","0","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}pembayaran","1","367"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}termpayment","-2","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}termpayment","0","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}termpayment","1","352"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}tipepayment","-2","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}tipepayment","0","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}tipepayment","1","352"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}v_bonuscustomer","-2","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}v_bonuscustomer","0","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}v_bonuscustomer","1","367"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}v_orderdetail","-2","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}v_orderdetail","0","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}v_orderdetail","1","367"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}v_piutang","-2","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}v_piutang","0","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}v_piutang","1","367"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}v_piutang_detail","-2","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}v_piutang_detail","0","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}v_piutang_detail","1","367"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}v_stock","-2","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}v_stock","0","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}v_stock","1","367"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}redeembonus","-2","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}redeembonus","0","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}redeembonus","1","367"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}dashboard.php","-2","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}dashboard.php","0","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}dashboard.php","1","367"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}p_invoice.php","-2","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}p_invoice.php","0","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}p_invoice.php","1","367"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}p_suratjalan.php","-2","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}p_suratjalan.php","0","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}p_suratjalan.php","1","367"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}stock","-2","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}stock","0","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}stock","1","352"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}titipmerk_validasi","-2","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}titipmerk_validasi","0","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}titipmerk_validasi","1","352"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}maklon_produk.php","-2","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}maklon_produk.php","0","0"],
    ["{E0FDE1D0-889A-402F-A577-286E80B13C3A}maklon_produk.php","1","8"]];
// User level table info
$USER_LEVEL_TABLES = [["pegawai","pegawai","Pegawai",true,"{E0FDE1D0-889A-402F-A577-286E80B13C3A}","PegawaiList"],
    ["userlevelpermissions","userlevelpermissions","userlevelpermissions",true,"{E0FDE1D0-889A-402F-A577-286E80B13C3A}","UserlevelpermissionsList"],
    ["userlevels","userlevels","userlevels",true,"{E0FDE1D0-889A-402F-A577-286E80B13C3A}","UserlevelsList"],
    ["customer","customer","Customer",true,"{E0FDE1D0-889A-402F-A577-286E80B13C3A}","CustomerList"],
    ["alamat_customer","alamat_customer","Alamat Kirim",true,"{E0FDE1D0-889A-402F-A577-286E80B13C3A}","AlamatCustomerList"],
    ["tipecustomer","tipecustomer","tipecustomer",true,"{E0FDE1D0-889A-402F-A577-286E80B13C3A}","TipecustomerList"],
    ["brand","brand","Brand",true,"{E0FDE1D0-889A-402F-A577-286E80B13C3A}","BrandList"],
    ["provinsi","provinsi","provinsi",true,"{E0FDE1D0-889A-402F-A577-286E80B13C3A}","ProvinsiList"],
    ["kabupaten","kabupaten","kabupaten",true,"{E0FDE1D0-889A-402F-A577-286E80B13C3A}","KabupatenList"],
    ["kecamatan","kecamatan","kecamatan",true,"{E0FDE1D0-889A-402F-A577-286E80B13C3A}","KecamatanList"],
    ["kelurahan","kelurahan","kelurahan",true,"{E0FDE1D0-889A-402F-A577-286E80B13C3A}","KelurahanList"],
    ["product","product","Product",true,"{E0FDE1D0-889A-402F-A577-286E80B13C3A}","ProductList"],
    ["d_jatuhtempo","d_jatuhtempo","Jatuh Tempo",true,"{E0FDE1D0-889A-402F-A577-286E80B13C3A}","DJatuhtempoList"],
    ["kategoribarang","kategoribarang","Kategori Barang",true,"{E0FDE1D0-889A-402F-A577-286E80B13C3A}","KategoribarangList"],
    ["jenisbarang","jenisbarang","Jenis Barang",true,"{E0FDE1D0-889A-402F-A577-286E80B13C3A}","JenisbarangList"],
    ["kemasanbarang","kemasanbarang","Kemasan Barang",true,"{E0FDE1D0-889A-402F-A577-286E80B13C3A}","KemasanbarangList"],
    ["kualitasbarang","kualitasbarang","Kualitas Barang",true,"{E0FDE1D0-889A-402F-A577-286E80B13C3A}","KualitasbarangList"],
    ["aplikasibarang","aplikasibarang","Aplikasi Barang",true,"{E0FDE1D0-889A-402F-A577-286E80B13C3A}","AplikasibarangList"],
    ["viskositasbarang","viskositasbarang","Viskositas Barang",true,"{E0FDE1D0-889A-402F-A577-286E80B13C3A}","ViskositasbarangList"],
    ["ekspedisi","ekspedisi","Ekspedisi",true,"{E0FDE1D0-889A-402F-A577-286E80B13C3A}","EkspedisiList"],
    ["rekening","rekening","Rekenign",true,"{E0FDE1D0-889A-402F-A577-286E80B13C3A}","RekeningList"],
    ["satuan","satuan","satuan",true,"{E0FDE1D0-889A-402F-A577-286E80B13C3A}","SatuanList"],
    ["npd","npd","Develop Sample",true,"{E0FDE1D0-889A-402F-A577-286E80B13C3A}","NpdList"],
    ["npd_terms","npd_terms","npd terms",true,"{E0FDE1D0-889A-402F-A577-286E80B13C3A}","NpdTermsList"],
    ["npd_status","npd_status","Detail Status",true,"{E0FDE1D0-889A-402F-A577-286E80B13C3A}","NpdStatusList"],
    ["npd_sample","npd_sample","Sample",true,"{E0FDE1D0-889A-402F-A577-286E80B13C3A}","NpdSampleList"],
    ["npd_review","npd_review","Review",true,"{E0FDE1D0-889A-402F-A577-286E80B13C3A}","NpdReviewList"],
    ["npd_extend","npd_extend","npd extend",true,"{E0FDE1D0-889A-402F-A577-286E80B13C3A}","NpdExtendList"],
    ["npd_confirm","npd_confirm","Confirm",true,"{E0FDE1D0-889A-402F-A577-286E80B13C3A}","NpdConfirmList"],
    ["npd_harga","npd_harga","Permintaan Harga",true,"{E0FDE1D0-889A-402F-A577-286E80B13C3A}","NpdHargaList"],
    ["serahterima","serahterima","Serah Terima Sample",true,"{E0FDE1D0-889A-402F-A577-286E80B13C3A}","SerahterimaList"],
    ["ijinhaki","ijinhaki","Ijin HKI",true,"{E0FDE1D0-889A-402F-A577-286E80B13C3A}","IjinhakiList"],
    ["ijinhaki_status","ijinhaki_status","Detail Status",true,"{E0FDE1D0-889A-402F-A577-286E80B13C3A}","IjinhakiStatusList"],
    ["ijinbpom","ijinbpom","Titip Merk BPOM",true,"{E0FDE1D0-889A-402F-A577-286E80B13C3A}","IjinbpomList"],
    ["ijinbpom_detail","ijinbpom_detail","Detail Titip Merk",true,"{E0FDE1D0-889A-402F-A577-286E80B13C3A}","IjinbpomDetailList"],
    ["ijinbpom_status","ijinbpom_status","Detail Status",true,"{E0FDE1D0-889A-402F-A577-286E80B13C3A}","IjinbpomStatusList"],
    ["order","order","Order",true,"{E0FDE1D0-889A-402F-A577-286E80B13C3A}","OrderList"],
    ["order_detail","order_detail","Detail Order",true,"{E0FDE1D0-889A-402F-A577-286E80B13C3A}","OrderDetailList"],
    ["deliveryorder","deliveryorder","Delivery Order",true,"{E0FDE1D0-889A-402F-A577-286E80B13C3A}","DeliveryorderList"],
    ["deliveryorder_detail","deliveryorder_detail","Detail Delivery Order",true,"{E0FDE1D0-889A-402F-A577-286E80B13C3A}","DeliveryorderDetailList"],
    ["invoice","invoice","Invoice",true,"{E0FDE1D0-889A-402F-A577-286E80B13C3A}","InvoiceList"],
    ["invoice_detail","invoice_detail","Detail Invoice",true,"{E0FDE1D0-889A-402F-A577-286E80B13C3A}","InvoiceDetailList"],
    ["suratjalan","suratjalan","Surat Jalan",true,"{E0FDE1D0-889A-402F-A577-286E80B13C3A}","SuratjalanList"],
    ["suratjalan_detail","suratjalan_detail","Detail Surat Jalan",true,"{E0FDE1D0-889A-402F-A577-286E80B13C3A}","SuratjalanDetailList"],
    ["pembayaran","pembayaran","Pembayaran",true,"{E0FDE1D0-889A-402F-A577-286E80B13C3A}","PembayaranList"],
    ["termpayment","termpayment","termpayment",true,"{E0FDE1D0-889A-402F-A577-286E80B13C3A}","TermpaymentList"],
    ["tipepayment","tipepayment","tipepayment",true,"{E0FDE1D0-889A-402F-A577-286E80B13C3A}","TipepaymentList"],
    ["v_bonuscustomer","v_bonuscustomer","Bonus Customer",true,"{E0FDE1D0-889A-402F-A577-286E80B13C3A}","VBonuscustomerList"],
    ["v_orderdetail","v_orderdetail","v orderdetail",true,"{E0FDE1D0-889A-402F-A577-286E80B13C3A}","VOrderdetailList"],
    ["v_piutang","v_piutang","Piutang Customer",true,"{E0FDE1D0-889A-402F-A577-286E80B13C3A}","VPiutangList"],
    ["v_piutang_detail","v_piutang_detail","Detail Piutang",true,"{E0FDE1D0-889A-402F-A577-286E80B13C3A}","VPiutangDetailList"],
    ["v_stock","v_stock","Stock",true,"{E0FDE1D0-889A-402F-A577-286E80B13C3A}","VStockList"],
    ["redeembonus","redeembonus","Redeem Bonus",true,"{E0FDE1D0-889A-402F-A577-286E80B13C3A}","RedeembonusList"],
    ["dashboard.php","dashboard2","Dashboard",true,"{E0FDE1D0-889A-402F-A577-286E80B13C3A}","Dashboard2"],
    ["p_invoice.php","p_invoice","Invoice",true,"{E0FDE1D0-889A-402F-A577-286E80B13C3A}","PInvoice"],
    ["p_suratjalan.php","p_suratjalan","Surat Jalan",true,"{E0FDE1D0-889A-402F-A577-286E80B13C3A}","PSuratjalan"],
    ["stock","stock","Stock",true,"{E0FDE1D0-889A-402F-A577-286E80B13C3A}","StockList"],
    ["titipmerk_validasi","titipmerk_validasi","titipmerk validasi",true,"{E0FDE1D0-889A-402F-A577-286E80B13C3A}","TitipmerkValidasiList"],
    ["maklon_produk.php","maklon_produk","Maklon Produk",true,"{E0FDE1D0-889A-402F-A577-286E80B13C3A}","MaklonProduk"]];

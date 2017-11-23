<!DOCTYPE html>
<html>

<head>
    <title>DANX</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <script type="text/javascript" src="../js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../js/jquery.form.js"></script>
    <script type="text/javascript" src="../js/custom.js"></script>
</head>

<body>

<header>
    <div class="container egov-width header bg-colored">
        <div class="row">
            <div class="col-md-9">
                <span class="prof-title"><?php echo $user->company; ?></span>
            </div>
            <div class="col-md-3">
                <div class="hd-right">
                    <span class="hdr-key">VÖEN</span>
                    <span class="hdr-val"><?php echo $user->voen; ?></span>
                </div>
            </div>
        </div>
    </div>
</header>


<div class="container egov-width main-info">
    <div class="row">

        <div class="col-md-2">
            <figure class="prof-img"> <img src="<?php echo $user->img; ?>"> </figure>
        </div>

        <div class="col-md-10">

            <div class="row">

                <div class="col-md-12 prof-type">
                    <a class="btn btn-<?php echo ($user->type ==2) ? 'danger' : 'success'; ?>"><?php echo ($user->type ==2) ? 'Hüquqi şəxs' : 'Fiziki şəxs'; ?></a>
                </div>

                <p class="vertical-space"></p>

                <div class="col-md-6">


                    <p>Soyadı , adı və atasının adı</p>
                    <p class="text-uppercase"><strong><?php echo $user->name; ?></strong></p>

                    <p class="vertical-space"></p>

                    <p>Doğum tarixi</p>
                    <p><strong><?php echo $user->date; ?></strong></p>

                </div>


                <?php if ($user->type ==2) { ?>

                <div class="col-md-6">

                    <p> VÖEN qeydiyyat adı</p>
                    <p><strong> <?php echo $user->company_long; ?> </strong> </p>

                    <p class="vertical-space"></p>


                    <p> VÖEN qeydiyyat ünvanı</p>
                    <p> <strong><?php echo $user->address; ?> </strong> </p>

                </div>

                <? } ?>

            </div>

        </div>
    </div>
</div>

<? /*

    <div class="container egov-width selects bg-colored">
        <div class="row">
            <div class="col-md-3 sel-title">Ərazini seçin:</div>
            <div class="col-md-9 inputs">

                <select class="form-control">
                    <option>Şəhərlərarası</option>
                    <option>Şəhər daxili</option>
                </select>

                <select class="form-control">
                    <option>Bakı</option>
                    <option>İsmayıllı</option>
                </select>

                <span class="move-icon"><img src="images/shuffle.png"> </span>

                <select class="form-control">
                    <option>Bakı</option>
                    <option>İsmayıllı</option>
                </select>
            </div>
        </div>
    </div>

    */?>

<div class="container bg-colored egov-width selects">
    <div class="row">
        <div class="col-md-2 sel-title">Əlaqə vasitələri:</div>
        <div class="col-md-10 inputs no-border">

            <label> Tel : <input type="text" name="phone" class="form-control" value="<?php echo $user->phone; ?>"></label>
            <label> E-poçt : <input type="text" name="email" class="form-control" value="<?php echo $user->email; ?>"></label>
            <img class="ad-info-save" src="/images/save.png">
            <span class="ad-info-status"></span>


        </div>
    </div>
</div>

<div class="container egov-width table-div">

    <div class="row">

        <table class="table">
            <thead>
            <tr>
                <th>№</th>
                <th>Avtomobil</th>
                <th>Sürücü</th>
                <th>Nömrəsi</th>
                <th>Növü</th>
                <th>Nəf/ton</th>
                <th>Sənədlər</th>
                <th>Ərazinin növü</th>
                <th>Region</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody id="tbody">

            </tbody>
        </table>


        <div class="under-table clearfix">
            <div class="ut-left"> <a class="add-vehicle" href="javascript:void(0)"> <img src="../images/plus.png"> Avtomobil əlavə et </a> </div>
            <div class="ut-right">  </div>
        </div>

        <form action="/ajax.php?action=vehicle" style="display: none;"  method="post" class="vehicle-form form-horizontal ">

            <img class="close-form" src="/images/close.png">


            <div class="form-group">
                <span class="col-sm-4 col-lg-3 control-label"></span>
                <div class="col-sm-8 col-lg-9 controls warning-msg"></div>
            </div>


            <div class="form-group">
                <span class="col-sm-4 col-lg-3 control-label">Avtomobil</span>
                <div class="col-sm-8 col-lg-9 controls"><input type="text" name="vehicle" class="form-control" value=""></div>
            </div>

            <div class="form-group">
                <span class="col-sm-4 col-lg-3 control-label">Sürücü</span>
                <div class="col-sm-8 col-lg-9 controls"><input type="text" name="driver" class="form-control" value=""></div>
            </div>

            <div class="form-group">
                <span class="col-sm-4 col-lg-3 control-label">Nömrəsi</span>
                <div class="col-sm-8 col-lg-9 controls"><input type="text" name="number" class="form-control half-width" value=""></div>
            </div>

            <div class="form-group types-area">
                <span class="col-sm-4 col-lg-3 control-label">Növü</span>
                <div class="col-sm-8 col-lg-9 controls">
                    <span data-val="1" class="vehicle-ico1"></span>
                    <span data-val="2" class="vehicle-ico2"></span>
                    <span data-val="3" class="vehicle-ico3"></span>
                    <input type="hidden" name="type" >
                </div>
            </div>

            <div class="form-group no-taxi">
                <span class="col-sm-4 col-lg-3 control-label">Nəfər / Ton</span>
                <div class="col-sm-8 col-lg-9 controls">
                    <input type="number" step="0.1" name="capacity" class="form-control half-width" value="0">
                </div>
            </div>

            <div class="form-group">
                <span class="col-sm-4 col-lg-3 control-label">Fəaliyyət ərazisinin növü</span>
                <div class="col-sm-8 col-lg-9 controls">
                    <select class="form-control half-width" name="regiontype">
                        <option value="1">Şəhərdaxili</option>
                        <option value="2">Şəhərlərarası</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <span class="col-sm-4 col-lg-3 control-label">Region</span>
                <div class="col-sm-8 col-lg-9 controls">

                    <select class="form-control half-width" name="region">
                        <option value="Ağcabədi">Ağcabədi</option>
                        <option value="Ağdam">Ağdam</option>
                        <option value="Ağdaş">Ağdaş</option>
                        <option value="Ağstafa">Ağstafa</option>
                        <option value="Ağsu">Ağsu</option>
                        <option value="Astara">Astara</option>
                        <option selected="selected" value="Bakı">Bakı</option>
                        <option value="Balakən">Balakən</option>
                        <option value="Beyləqan">Beyləqan</option>
                        <option value="Bərdə">Bərdə</option>
                        <option value="Biləsuvar">Biləsuvar</option>
                        <option value="Cəlilabad">Cəlilabad</option>
                        <option value="Culfa">Culfa</option>
                        <option value="Daşkəsən">Daşkəsən</option>
                        <option value="Füzuli">Füzuli</option>
                        <option value="Gədəbəy">Gədəbəy</option>
                        <option value="Gəncə">Gəncə</option>
                        <option value="Goranboy">Goranboy</option>
                        <option value="Göyçay">Göyçay</option>
                        <option value="Göygöl">Göygöl</option>
                        <option value="Göytəpə">Göytəpə</option>
                        <option value="Hacıqabul">Hacıqabul</option>
                        <option value="Horadiz">Horadiz</option>
                        <option value="İmişli">İmişli</option>
                        <option value="İsmayıllı">İsmayıllı</option>
                        <option value="Kürdəmir">Kürdəmir</option>
                        <option value="Lerik">Lerik</option>
                        <option value="Lənkəran">Lənkəran</option>
                        <option value="Masallı">Masallı</option>
                        <option value="Mingəçevir">Mingəçevir</option>
                        <option value="Nabran">Nabran</option>
                        <option value="Naftalan">Naftalan</option>
                        <option value="Naxçıvan">Naxçıvan</option>
                        <option value="Neftçala">Neftçala</option>
                        <option value="Oğuz">Oğuz</option>
                        <option value="Qax">Qax</option>
                        <option value="Qazax">Qazax</option>
                        <option value="Qəbələ">Qəbələ</option>
                        <option value="Qobustan">Qobustan</option>
                        <option value="Quba">Quba</option>
                        <option value="Qusar">Qusar</option>
                        <option value="Saatlı">Saatlı</option>
                        <option value="Sabirabad">Sabirabad</option>
                        <option value="Şabran">Şabran</option>
                        <option value="Salyan">Salyan</option>
                        <option value="Şamaxı">Şamaxı</option>
                        <option value="Şəki">Şəki</option>
                        <option value="Şəmkir">Şəmkir</option>
                        <option value="Şirvan">Şirvan</option>
                        <option value="Siyəzən">Siyəzən</option>
                        <option value="Sumqayıt">Sumqayıt</option>
                        <option value="Tərtər">Tərtər</option>
                        <option value="Tovuz">Tovuz</option>
                        <option value="Ucar">Ucar</option>
                        <option value="Xaçmaz">Xaçmaz</option>
                        <option value="Xırdalan">Xırdalan</option>
                        <option value="Xızı">Xızı</option>
                        <option value="Xudat">Xudat</option>
                        <option value="Yevlax">Yevlax</option>
                        <option value="Zaqatala">Zaqatala</option>
                        <option value="Zərdab">Zərdab</option>
                    </select>

                    <select class="form-control half-width" name="toregion">
                        <option value="Ağcabədi">Ağcabədi</option>
                        <option value="Ağdam">Ağdam</option>
                        <option value="Ağdaş">Ağdaş</option>
                        <option value="Ağstafa">Ağstafa</option>
                        <option value="Ağsu">Ağsu</option>
                        <option value="Astara">Astara</option>
                        <option selected="selected" value="Bakı">Bakı</option>
                        <option value="Balakən">Balakən</option>
                        <option value="Beyləqan">Beyləqan</option>
                        <option value="Bərdə">Bərdə</option>
                        <option value="Biləsuvar">Biləsuvar</option>
                        <option value="Cəlilabad">Cəlilabad</option>
                        <option value="Culfa">Culfa</option>
                        <option value="Daşkəsən">Daşkəsən</option>
                        <option value="Füzuli">Füzuli</option>
                        <option value="Gədəbəy">Gədəbəy</option>
                        <option value="Gəncə">Gəncə</option>
                        <option value="Goranboy">Goranboy</option>
                        <option value="Göyçay">Göyçay</option>
                        <option value="Göygöl">Göygöl</option>
                        <option value="Göytəpə">Göytəpə</option>
                        <option value="Hacıqabul">Hacıqabul</option>
                        <option value="Horadiz">Horadiz</option>
                        <option value="İmişli">İmişli</option>
                        <option value="İsmayıllı">İsmayıllı</option>
                        <option value="Kürdəmir">Kürdəmir</option>
                        <option value="Lerik">Lerik</option>
                        <option value="Lənkəran">Lənkəran</option>
                        <option value="Masallı">Masallı</option>
                        <option value="Mingəçevir">Mingəçevir</option>
                        <option value="Nabran">Nabran</option>
                        <option value="Naftalan">Naftalan</option>
                        <option value="Naxçıvan">Naxçıvan</option>
                        <option value="Neftçala">Neftçala</option>
                        <option value="Oğuz">Oğuz</option>
                        <option value="Qax">Qax</option>
                        <option value="Qazax">Qazax</option>
                        <option value="Qəbələ">Qəbələ</option>
                        <option value="Qobustan">Qobustan</option>
                        <option value="Quba">Quba</option>
                        <option value="Qusar">Qusar</option>
                        <option value="Saatlı">Saatlı</option>
                        <option value="Sabirabad">Sabirabad</option>
                        <option value="Şabran">Şabran</option>
                        <option value="Salyan">Salyan</option>
                        <option value="Şamaxı">Şamaxı</option>
                        <option value="Şəki">Şəki</option>
                        <option value="Şəmkir">Şəmkir</option>
                        <option value="Şirvan">Şirvan</option>
                        <option value="Siyəzən">Siyəzən</option>
                        <option value="Sumqayıt">Sumqayıt</option>
                        <option value="Tərtər">Tərtər</option>
                        <option value="Tovuz">Tovuz</option>
                        <option value="Ucar">Ucar</option>
                        <option value="Xaçmaz">Xaçmaz</option>
                        <option value="Xırdalan">Xırdalan</option>
                        <option value="Xızı">Xızı</option>
                        <option value="Xudat">Xudat</option>
                        <option value="Yevlax">Yevlax</option>
                        <option value="Zaqatala">Zaqatala</option>
                        <option value="Zərdab">Zərdab</option>
                    </select>

                </div>
            </div>

            <div class="form-group">
                <span class="col-sm-4 col-lg-3 control-label">Müddət (ay)</span>
                <div class="col-sm-8 col-lg-9 controls">
                    <input type="number" step="1" name="months" class="form-control half-width" value="1">
                </div>
            </div>

            <input type="hidden" name="id" value="">


            <div class="form-group">
                <span class="col-sm-4 col-lg-3 control-label">Texpasport (ön)</span>
                <div class="col-sm-8 col-lg-9 controls"><input type="file" name="doc1_1"> <div class="file-exists"></div> </div>
            </div>

            <div class="form-group">
                <span class="col-sm-4 col-lg-3 control-label">Texpasport (arxa)</span>
                <div class="col-sm-8 col-lg-9 controls"><input type="file" name="doc1_2"><div class="file-exists"></div> </div>
            </div>

            <div class="form-group">
                <span class="col-sm-4 col-lg-3 control-label">Sürücülük vəsiqəsi (ön)</span>
                <div class="col-sm-8 col-lg-9 controls"><input type="file" name="doc2_1"><div class="file-exists"></div>  </div>
            </div>

            <div class="form-group">
                <span class="col-sm-4 col-lg-3 control-label">Sürücülük vəsiqəsi (arxa)</span>
                <div class="col-sm-8 col-lg-9 controls"><input type="file" name="doc2_2"><div class="file-exists"></div>  </div>
            </div>

            <div class="form-group">
                <span class="col-sm-4 col-lg-3 control-label"></span>
                <div class="col-sm-8 col-lg-9 controls"><h5>Əgər texpasport başqasının adınadırsa</h5></div>
            </div>

            <div class="form-group">
                <span class="col-sm-4 col-lg-3 control-label">Etibarnamə </span>
                <div class="col-sm-8 col-lg-9 controls"><input type="file" name="doc3"><div class="file-exists"></div> </div>
            </div>

            <div class="loading-overlay" style="display: none"></div>

            <div class="final-div"> <div class="message-box"></div>  <button type="submit" class="do-action" href="javascript:void(0)"> Əməliyyatı tamamla </button> </div>

        </form>


    </div>


</div>



</body>

</html>
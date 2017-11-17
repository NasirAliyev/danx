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
    <script type="text/javascript" src="../js/custom.js"></script>
</head>

<body>

<header>
    <div class="container egov-width header bg-colored">
        <div class="row">
            <div class="col-md-9">
                <span class="prof-title">"WhiteRoof" MMC</span>
            </div>
            <div class="col-md-3">
                <div class="hd-right">
                    <span class="hdr-key">VÖEN</span>
                    <span class="hdr-val">9900038501</span>
                </div>
            </div>
        </div>
    </div>
</header>


<div class="container egov-width main-info">
    <div class="row">

        <div class="col-md-2">
            <figure class="prof-img"> <img src="../images/pasp.png"> </figure>
        </div>

        <div class="col-md-10">

            <div class="row">

                <div class="col-md-12 prof-type">
                    <a class="btn btn-danger">Hüquqi şəxs</a>
                </div>

                <p class="vertical-space"></p>

                <div class="col-md-6">


                    <p>Soyadı , adı və atasının adı</p>
                    <p class="text-uppercase"><strong>Novruzov Emin Bəlahər oğlu</strong></p>

                    <p class="vertical-space"></p>

                    <p>Doğum tarixi</p>
                    <p><strong>08.09.1986</strong></p>

                </div>

                <div class="col-md-6">

                    <p> VÖEN qeydiyyat adı</p>
                    <p><strong> "WhiteRoof" MƏHDUD MƏSULİYYƏTLİ CƏMİYYƏTİ </strong> </p>

                    <p class="vertical-space"></p>


                    <p> VÖEN qeydiyyat ünvanı</p>
                    <p> <strong>Dilarə küç, 185 </strong> </p>

                </div>
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
        <div class="col-md-3 sel-title">Əlaqə vasitələri:</div>
        <div class="col-md-9 inputs no-border">

            <label> Tel : <input type="text" class="form-control"></label>
            <label> E-poçt : <input type="text" class="form-control"></label>

        </div>
    </div>
</div>

<div class="container egov-width table-div">

    <div class="row">

        <table class="table">
            <thead>
            <tr>
                <th>№</th>
                <th>Avtomobilin adı</th>
                <th>Nömrəsi</th>
                <th>Növü</th>
                <th>Nəf/ton</th>
                <th>Sənədlər</th>
                <th>Fəaliyyət ərazisinin növü</th>
                <th>Region</th>
                <th>Status</th>
                <th>Əməliyyat</th>
            </tr>
            </thead>
            <tbody>



            <tr>
                <td>1</td>
                <td>İveco Urban</td>
                <td>10-GJ-007</td>
                <td>
                    <span class="vehicle-ico2 active"></span>
                </td>
                <td>54 nəf</td>
                <td><span class="files">texpasport.pdf <img src="../images/plus-blue.png"> </span></td>
                <td>Şəhərdaxili</td>
                <td>Bakı</td>
                <td>Gözlənilir...</td>
                <td>
                    <a href="javascript:void(0)" class="btn btn-info edit"><i class="glyphicon-edit"></i> </a>
                    <a href="javascript:void(0)" class="btn btn-danger delete"> <i class="glyphicon-remove"></i></a>
                </td>
            </tr>



            </tbody>
        </table>


        <div class="under-table clearfix">
            <div class="ut-left"> <a href="javascript:void(0)"> <img src="../images/plus.png"> Avtomobil əlavə et </a> </div>
            <div class="ut-right">  </div>
        </div>

        <form action="/ajax.php?action=vehicle" enctype="multipart/form-data" class="vehicle-form form-horizontal ">


            <div class="form-group">
                <span class="col-sm-4 col-lg-3 control-label">Avtomobilin adı</span>
                <div class="col-sm-8 col-lg-9 controls"><input type="text" name="vehicle" class="form-control" value=""></div>
            </div>

            <div class="form-group">
                <span class="col-sm-4 col-lg-3 control-label">Nömrəsi</span>
                <div class="col-sm-8 col-lg-9 controls"><input type="text" name="number" class="form-control half-width" value=""></div>
            </div>

            <div class="form-group">
                <span class="col-sm-4 col-lg-3 control-label">Növü</span>
                <div class="col-sm-8 col-lg-9 controls">
                    <span class="vehicle-ico1"></span>
                    <span class="vehicle-ico2"></span>
                    <span class="vehicle-ico3"></span>
                    <input type="hidden" name="type" >
                </div>
            </div>

            <div class="form-group">
                <span class="col-sm-4 col-lg-3 control-label">Nəfər / Ton</span>
                <div class="col-sm-8 col-lg-9 controls">
                    <input type="number" step="1" name="capacity" class="form-control half-width" value="0">
                    <select class="form-control half-width" name="capacitytype">
                        <option value="1">Nəfər</option>
                        <option value="2">Ton</option>
                    </select>
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
                        <option value="Abşeron">Abşeron</option>
                        <option value="Bakı">Bakı</option>
                        <option value="Sumqayıt">Sumqayıt</option>
                    </select>
                    <select class="form-control half-width" name="region">
                        <option value="Abşeron">Abşeron</option>
                        <option value="Bakı">Bakı</option>
                        <option value="Sumqayıt">Sumqayıt</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <span class="col-sm-4 col-lg-3 control-label">Müddət (ay)</span>
                <div class="col-sm-8 col-lg-9 controls">
                    <input type="number" step="1" name="months" class="form-control half-width" value="1">
                </div>
            </div>


            <div class="form-group">
                <span class="col-sm-4 col-lg-3 control-label">Texpasport (ön)</span>
                <div class="col-sm-8 col-lg-9 controls"><input type="file" name="doc1-1"></div>
            </div>

            <div class="form-group">
                <span class="col-sm-4 col-lg-3 control-label">Texpasport (arxa)</span>
                <div class="col-sm-8 col-lg-9 controls"><input type="file" name="doc1-2"></div>
            </div>

            <div class="form-group">
                <span class="col-sm-4 col-lg-3 control-label">Sürücülük vəsiqəsi (ön)</span>
                <div class="col-sm-8 col-lg-9 controls"><input type="file" name="doc2-1"> </div>
            </div>

            <div class="form-group">
                <span class="col-sm-4 col-lg-3 control-label">Sürücülük vəsiqəsi (arxa)</span>
                <div class="col-sm-8 col-lg-9 controls"><input type="file" name="doc2-2"> </div>
            </div>

            <div class="form-group">
                <span class="col-sm-4 col-lg-3 control-label"></span>
                <div class="col-sm-8 col-lg-9 controls"><h5>Əgər texpasport başqasının adınadırsa</h5></div>
            </div>

            <div class="form-group">
                <span class="col-sm-4 col-lg-3 control-label">Etibarnamə </span>
                <div class="col-sm-8 col-lg-9 controls"><input type="file" name="doc3"></div>
            </div>


            <div class="final-div">   <a class="do-action" href="javascript:void(0)"> Əməliyyatı tamamla </a> </div>

        </form>


    </div>


</div>



</body>

</html>
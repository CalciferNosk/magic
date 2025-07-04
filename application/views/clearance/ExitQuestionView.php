<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Online Service Appointment Motortrade">
    <meta name="<?= $this->security->get_csrf_token_name(); ?>" content="<?= $this->security->get_csrf_hash(); ?>" />
    <meta name="author" content="The company's slogan “Motorsiklo Sigurado, Alaga Ka Dito” sums up its number one priority — Total Customer Satisfaction is what we always guarantee!">
    <link rel="icon" href="assets/favicon.ico">
    <title>EMS | Clearance</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<style>
    p {
        margin: unset;
    }

    .sub-question {
        margin-left: 20px !important;
        line-height: 30px;

    }

    .subofsub {
        margin-left: 40px !important;
        line-height: 30px;
    }

    .subAnswer {
        margin-left: 60px !important;
        line-height: 30px;
    }

    input {
        margin-right: 5px;
    }

    .underline {
        width: 300px;
        background:
            linear-gradient(#000, #000) center bottom 5px /calc(100% - 10px) 2px no-repeat;
        background-color: #fcfcfc;
        border: unset;
        height: 30px;
        padding: 10px;
    }

    .underline:focus {
        outline: none;
    }

    @media only screen and (max-width: 600px) {
        .underline {
            width: 200px;
        }
    }

    #submit-interview:hover {
        background-color: yellow !important;
        color: #1533b2;
        border-color: white;
    }

    .main-question {
        font-weight: 600;
    }

    .mobile-input {
        width: 50%;
    }

    @media only screen and (max-width : 900px) {
        .mobile-input {
            width: 100% !important;
        }

    }
</style>

<body>
   
    <div class="card shadow-lg" style="margin: 10%;margin-left:10%; padding:40px">
      
        <form action="#" onsubmit="return false" METHOD="POST" id="exit_interview_form">
            <h4 align="center">EXIT INTERVIEW FORM</h4>
            <br>
            <?php
            // var_dump('<pre>',$exit_question);die;
            $html = '';

            foreach ($exit_question as $exit) :
                $html .= '<div class="container">';
                $html .= '<p class="main-question" style="padding-bottom:5px">' . $exit->question . '</p>';

                if ($exit->subQuestion == null) {

                    if ($exit->answer == null) {

                        // var_dump('<pre>',$exit);die;
                        if ($exit->questionType == 'MULTIPLE') {
                            $html .= "<div id='show-item' class='question-id-{$exit->id} mt-3'>
                            <div class='row'>
                            <div class='col-md-1 mb-3 mt-1'>
                                <button type=button class='btn btn-success add_item_btn' id=''><i class='fa fa-plus'></i></button>
                                </div>
                                <div class='col-md-3 mb-3 mt-1'>
                                    <input class=' null-subquestion form-control'  type='text' name='name[]' id='txtid' placeholder='Name' required/>
                                </div>
                                <div class='col-md-3 mb-3 mt-1'>
                                    <input class=' null-subquestion form-control'  type='text' name='branch[]' id='txtid' placeholder='Branch/ Department'required/>
                                </div>
                                <div class='col-md-2 mb-3 mt-1'>
                                    <input class=' null-subquestion form-control'  type='text' name='datefrom[]'onfocus='(this.type=`date`)' onblur='(this.type=`text`)' id='txtid' placeholder='From' required/>
                                </div>
                                <div class='col-md-2 mb-3 mt-1'>
                                    <input class=' null-subquestion form-control'  type='text' name='dateto[]'onfocus='(this.type=`date`)' onblur='(this.type=`text`)' id='txtid' placeholder='To' required/>
                                </div>
                              
                            </div>
                          </div>";
                        } elseif ($exit->questionType == 'NUMBER') {

                            $html .=
                                "<div class='m-2'>
                                            <div class='input-group mb-3 mobile-input'>
                                                <span class='input-group-text' id='basic-addon1'>+639</span>
                                                <input name='mobile_number' type='text' onkeypress='if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;' maxlength='9'  minlength='9'  class='form-control' placeholder='Enter Mobile Number excluded 09xxxxxxxxx' aria-label='Username' aria-describedby='basic-addon1'>
                                            </div>
                                        </div>";
                        }
                        else if($exit->questionType == 'TEXTAREA'){
                            $html .=  "<div class='m-2'>
                                            <div class='input-group mb-3'>
                                                <textarea class='form-control' name='suggestion_". $exit->id ."' type='text'aria-label='Username' placeholder='Type here' aria-describedby='basic-addon1' required></textarea>
                                            </div>
                                        </div>";
                        } 
                        else {
                            $html .=  "<div class='m-2'>
                                            <div class='input-group mb-3'>
                                                <input class='form-control' name='mobile_number' type='text'aria-label='Username' placeholder='Type here' aria-describedby='basic-addon1'>
                                            </div>
                                        </div>";
                        }
                    } else {

                        foreach ($exit->answer as $key => $subAnswer) :

                            $class = $subAnswer->addReason == 1 ? 1 : 0;
                            $no_class = $subAnswer->addReason == 1 ? 'id_' . $subAnswer->questionID : '';
                            $addreason = $subAnswer->addReason == 1 ? '<br><input style="margin-left:50px" name="remarks_' . $subAnswer->id . '"  class="underline require' . $class . ' req_' . $subAnswer->questionID . ' specific_' . $subAnswer->id . ' " placeholder=" Type here...">' : '';
                            // $required = $subAnswer->isRequired == 1 ? 'required': '';
                            //this question is for letter A
                            $html .= '<span class="subofsub" style="display:inline-flex"><input id="dynamic_' . $subAnswer->id . '" data-specific="' . $subAnswer->id . '" data-no="' . $subAnswer->questionID . '" class="second_q no_' .  $class  . ' ' . $no_class . ' qid' . $subAnswer->questionID . ' all_' . $subAnswer->id . '" type="radio"  value="' . $subAnswer->id  . '" name="subAnswer-' . $subAnswer->questionID . '"   required/><label for="dynamic_' . $subAnswer->id . '" style="margin:unset">' . $subAnswer->answer . '</label></span>' . $addreason . '<br>';
                        endforeach;
                    }
                } else {

                    #sub questiond
                    foreach ($exit->subQuestion as $key => $sub) :
                        $required = $sub->isRequired == 1 ? 'required' : '';
                        $html .= ' <div class=" first sub-question not-null-subquestion "> <input class="not-null-subquestion nns-' . $key . '" data-mssg="' . $key . '" value="' . $sub->id . '" type="' . $sub->questionType . '" name="subquestion" ><span class="main-question">' . $sub->question . '</span><br>';
                        if ($sub->subQuestion == null) {

                            foreach ($sub->answer as $subAnswer) :
                                    $class = $subAnswer->addReason == 1 ? 1 : 0;
                                    $no_class = $subAnswer->addReason == 1 ? 'id_' . $subAnswer->questionID : '';
                                    $required = $subAnswer->addReason == 1?'<br><input style="margin-left:50px" name="remarks_' . $subAnswer->id . '"  class="underline require' . $class . ' req_' . $subAnswer->questionID . ' specific_' . $subAnswer->id . ' " placeholder=" Type here...">' : ''; 
                                $html .= '<span class="subofsub" style="display:inline-flex"><input id="qsec_' . $subAnswer->id . '" class="second  s_' . $subAnswer->questionID . '" type="radio" value="' . $subAnswer->id . '" name="question-' . $sub->id . '" data-reason="' . $subAnswer->addReason .  '" ><label style="margin:unset"  for="qsec_' . $subAnswer->id . '">' . $subAnswer->answer . '</label></span>'.$required.'<br>';
                            endforeach;
                        } else {

                            foreach ($sub->subQuestion as $subofsub) :
                                $html .= '<div class="subofsub" > <input id="q_' . $subofsub->id . '" class="second s_' . $subofsub->id . ' sec" type="radio"  value="' . $subofsub->id . '" name="second' . $subofsub->parentQuestionID . '"><label class="main-question" for="q_' . $subofsub->id . '">' . $subofsub->question . ' </label><br>';
                                if ($subofsub->answer == null) {
                                    $html .= '';
                                } else {

                                    foreach ($subofsub->answer as $subAnswer) :
                                        $html .= '<span class="subAnswer"  style="display:inline-flex"><input id="qlast_' . $subAnswer->id . '" class="third t_' . $subAnswer->questionID . '" value="' . $subAnswer->id . '" type="radio" name="third' . $subofsub->id . '" data-reason="' . $subAnswer->addReason . '"><label style="margin:unset" for="qlast_' . $subAnswer->id . '">' . $subAnswer->answer . '</label></span><br>';
                                    endforeach;
                                }
                                $html .= '</div>'; #end of class="subofsub"
                            endforeach;
                        }
                        $html .= '</div>'; #end of class="sub-question"
                    endforeach;
                }
                $html .= ' </div>'; # end of  class="container"
            endforeach;

            echo $html;
            ?>
            <center><button style="width:150px;height:50px;font-size:160%;font-weight:500; background-color:#1533b2;" id="submit-interview" type="submit" class="btn btn-primary">SUBMIT</button></center>
        </form>
    </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    var base_url = '<?= base_url() ?>';
</script>
<script src="<?= base_url() ?>assets/clearance_assets/js/exit_clearance_manual_validation.js?<?= bin2hex(random_bytes(20)); ?>"></script>
<script>
    $(document).ready(function() {
  

        $('.add_item_btn').on('click', function(e) {
            e.preventDefault();
            $('#show-item').prepend(`
                                <div class='row'>
                                    <div class='col-md-1 mb-3 mt-1'>
                                        <button type=button class='btn btn-danger remove_item_btn' id=''><i class='fa fa-trash'></i></button>
                                    </div>
                                    <div class='col-md-3 mb-3 mt-1'>
                                        <input class=' null-subquestion form-control'  type='text' name='name[]' id='txtid' placeholder='name' required/>
                                    </div>
                                    <div class='col-md-3 mb-3 mt-1'>
                                        <input class=' null-subquestion form-control'  type='text' name='branch[]' id='txtid' placeholder='Branch/ Department' required/>
                                    </div>
                                    <div class='col-md-2 mb-3 mt-1'>
                                        <input class=' null-subquestion form-control'  type='text' name='datefrom[]'onfocus='(this.type="date")' onblur='(this.type="text")' id='txtid' placeholder='From' required/>
                                    </div>
                                    <div class='col-md-2 mb-3 mt-1'>
                                        <input class=' null-subquestion form-control'  type='text' name='dateto[]'onfocus='(this.type="date")' onblur='(this.type="text")' id='txtid' placeholder='To' required/>
                                    </div>
                                    
                                </div>`);
        })
        $(document).on('click', '.remove_item_btn', function() {
            let row_item = $(this).parent().parent();
            $(row_item).remove();
        })

    })
</script>

</html>
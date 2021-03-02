<?php
require_once "./Database/CSRF.php";
?>
<!--Register Modal-->
<div class="modal fade registerModal m-auto" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content rounded-0">
            <div class="row">
                <div class="col-sm-12 col-lg-7 color-blue-bg d-flex justify-content-center align-items-center">
                    <img src="./assets/signipanimation.gif" class="img-fluid" id="registergif">
                </div>
                <div class="col-sm-12 col-lg-5 py-4">
                    <div class="pb-3 text-right">
                                    <span class="btn" data-dismiss="modal">
                                        <i class="fas fa-times-circle"></i>
                                    </span>
                        <h1 class="font-roboto text-center">Registration</h1>
                        <h6 class="font-roboto text-center">Be ready for the brainstorming</h6>
                    </div>
                    <form action="./Database/register.php" method="post" id="myf" enctype="multipart/form-data" class="px-4">
                        <?php CSRF::create_token(); ?>
                        <div class="row font-baloo">
                            <div class="form-group col-md-6">
                                <label class="color-second" for="fname">First Name</label>
                                <input type="text" id="fnameTemp" name="fnameTemp" class="form-control rounded" maxlength="25">
                                <input type="text" id="fname" name="fname" hidden class="form-control rounded">
                            </div>
                            <div class="col-md-6">
                                <label class="color-second" for="lname">Last Name</label>
                                <input type="text" id="lnameTemp" name="lnameTemp" class="form-control rounded" maxlength="25">
                                <input type="text" id="lname" name="lname" hidden class="form-control rounded">
                            </div>
                        </div>

                        <div class="row form-group font-baloo">
                            <div class="col-md-12">
                                <label class="color-second" for="gender">Gender</label><br>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" value="male" id="male" name="gender" class="custom-control-input">
                                    <label class="custom-control-label" for="male">Male</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline female">
                                    <input type="radio" value="female" id="female" name="gender" class="custom-control-input">
                                    <label class="custom-control-label" for="female">Female</label>
                                </div>
                            </div>
                        </div>

                        <div class="row form-group font-baloo">
                            <div class="col-md-12">
                                <label class="font-baloo" for="inst">Institute</label>
                                <select id="inst" name="inst" class="form-control rounded custom-select">
                                    <option value="">Select your Institute</option>
                                    <option value="CSPIT">CSPIT</option>
                                    <option value="DEPSTAR">DEPSTAR</option>
                                    <option value="CMPICA">CMPICA</option>
                                    <option value="RPCP">RPCP</option>
                                    <option value="IIIM">IIIM</option>
                                    <option value="PDPIAS">PDPIAS</option>
                                    <option value="ARIP">ARIP</option>
                                    <option value="MTIN">MTIN</option>
                                    <option value="CIPS">CIPS</option>
                                </select>
                            </div>
                        </div>

                        <div class="row form-group font-baloo">
                            <div class="col-md-12">
                                <label class="font-baloo" for="dept">Department</label>
                                <select id="dept" name="dept" class="form-control rounded custom-select">
                                    <option value="">First Select Institue</option>
                                </select>
                            </div>
                        </div>

                        <div class="row form-group font-baloo">
                            <div class="col-md-12">
                                <label class="color-second" for="sid">Student ID</label>
                                <input type="text" id="sidTemp" name="sidTemp" class="form-control rounded" maxlength="15">
                                <input type="text" id="sid" name="sid" hidden class="form-control rounded">
                            </div>
                        </div>

                        <div class="row form-group font-baloo">
                            <div class="col-md-12">
                                <label class="color-second" for="phno">Contact No.</label>
                                <input type="text" id="phnoTemp" name="phnoTemp" class="form-control rounded" maxlength="10">
                                <input type="text" id="phno" name="phno" hidden class="form-control rounded">
                            </div>
                        </div>

                        <div class="row form-group font-baloo">
                            <div class="col-md-12">
                                <label class="color-second" for="email">Email</label>
                                <input type="email" id="emailRTemp" name="emailRTemp" class="form-control rounded" maxlength="35">
                                <input type="email" id="emailR" name="emailR" hidden class="form-control rounded">
                            </div>
                        </div>

                        <div class="row form-group font-baloo">
                            <div class="col-md-12">
                                <label class="color-second" for="pswd">Password</label>
                                <div class="input-group pswd">
                                    <input type="password" id="pswdTemp" name="pswdTemp" class="form-control" maxlength="20">
                                    <input type="password" id="pswd" name="pswd" hidden class="form-control">
                                    <div class="input-group-append" id="eye">
                                        <span class="input-group-text"><i class="fa fa-eye"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group font-baloo">
                            <div class="col-md-6">
                                <div class="g-recaptcha" data-sitekey="6LcyN8gZAAAAACRWo9vaOoIbkc1odTVurr1G4CgE"></div>
                                <input type="hidden" class="hiddenRecaptcha required" name="hiddenRecaptcha" id="hiddenRecaptcha">
                            </div>
                        </div>

                        <div class="row form-group font-baloo mb-0">
                            <div class="col-md-6 mx-auto">
                                <button class="btn btn-hover color d-block mx-auto my-1 my-lg-0" type="submit" id="submit" name="submit">Register</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!--!Register Modal-->
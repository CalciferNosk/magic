
<style>
    /* Please ❤ this if you like it! */

@import url("https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap");

*,
*::before,
*::after {
  box-sizing: border-box;
}

.sec-center {
  position: relative;
  max-width: 100%;
  text-align: center;
  z-index: 200;
}
/* [type="checkbox"]:checked,
[type="checkbox"]:not(:checked) {
  position: absolute;
  left: -9999px;
  opacity: 0;
  pointer-events: none;
} */
.dark-light:checked + label,
.dark-light:not(:checked) + label {
  position: fixed;
  top: 40px;
  right: 40px;
  z-index: 20000;
  display: block;
  border-radius: 50%;
  width: 46px;
  height: 46px;
  cursor: pointer;
  transition: all 200ms linear;
  box-shadow: 0 0 25px rgba(255, 235, 167, 0.45);
}
.dark-light:checked + label {
  transform: rotate(360deg);
}
.dark-light:checked + label:after,
.dark-light:not(:checked) + label:after {
  position: absolute;
  content: "";
  top: 1px;
  left: 1px;
  overflow: hidden;
  z-index: 2;
  display: block;
  border-radius: 50%;
  width: 44px;
  height: 44px;
  background-color: #102770;
  background-image: url("https://assets.codepen.io/1462889/moon.svg");
  background-size: 20px 20px;
  background-repeat: no-repeat;
  background-position: center;
  transition: all 200ms linear;
  opacity: 0;
}
.dark-light:checked + label:after {
  opacity: 1;
}
.dark-light:checked + label:before,
.dark-light:not(:checked) + label:before {
  position: absolute;
  content: "";
  top: 0;
  left: 0;
  overflow: hidden;
  z-index: 1;
  display: block;
  border-radius: 50%;
  width: 46px;
  height: 46px;
  background-color: #48dbfb;
  background-image: url("https://assets.codepen.io/1462889/sun.svg");
  background-size: 25px 25px;
  background-repeat: no-repeat;
  background-position: center;
  transition: all 200ms linear;
}
.dark-light:checked + label:before {
  background-color: #000;
}
.light-back {
  position: fixed;
  top: 0;
  left: 0;
  z-index: 1;
  background-color: #fff;
  overflow: hidden;
  background-image: url("https://s3-us-west-2.amazonaws.com/s.cdpn.io/1462889/pat-back.svg");
  background-position: center;
  background-repeat: repeat;
  background-size: 4%;
  height: 100%;
  width: 100%;
  transition: all 200ms linear;
  opacity: 0;
}
.dark-light:checked ~ .light-back {
  opacity: 1;
}
.dropdown:checked + label,
.dropdown:not(:checked) + label {
  position: relative;
  font-family: "Roboto", sans-serif;
  font-weight: 500;
  font-size: 15px;
  line-height: 2;
  height: 50px;
  transition: all 200ms linear;
  border-radius: 4px;
  width: 220px;
  letter-spacing: 1px;
  display: -webkit-inline-flex;
  display: -ms-inline-flexbox;
  display: inline-flex;
  -webkit-align-items: center;
  -moz-align-items: center;
  -ms-align-items: center;
  align-items: center;
  -webkit-justify-content: center;
  -moz-justify-content: center;
  -ms-justify-content: center;
  justify-content: center;
  -ms-flex-pack: center;
  text-align: center;
  border: none;
  /* background-color:; */
  cursor: pointer;
  color: #102770;
  /* box-shadow: 0 12px 35px 0 rgba(255, 235, 167, 0.15); */
}
.dark-light:checked ~ .sec-center .for-dropdown {
  background-color: #102770;
  color: #ffeba7;
  box-shadow: 0 12px 35px 0 rgba(16, 39, 112, 0.25);
}
.dropdown:checked + label:before,
.dropdown:not(:checked) + label:before {
  position: fixed;
  top: 0;
  left: 0;
  content: "";
  width: 100%;
  height: 100%;
  z-index: -1;
  cursor: auto;
  pointer-events: none;
}
.dropdown:checked + label:before {
  pointer-events: auto;
}
.dropdown:not(:checked) + label .uil {
  font-size: 24px;
  margin-left: 10px;
  transition: transform 200ms linear;
}
.dropdown:checked + label .uil {
  transform: rotate(180deg);
  font-size: 24px;
  margin-left: 10px;
  transition: transform 200ms linear;
}
.section-dropdown {
  position: absolute;
  padding: 5px;
  background-color: white;
  top: 70px;
  right: -20px ;
  width: 127%;
  border-radius: 4px;
  display: block;
  box-shadow: 0 14px 35px 0 rgba(9, 9, 12, 0.4);
  z-index: 2;
  opacity: 0;
  pointer-events: none;
  transform: translateY(20px);
  transition: all 200ms linear;
}
.dark-light:checked ~ .sec-center .section-dropdown {
  background-color: white;
  box-shadow: 0 14px 35px 0 rgba(9, 9, 12, 0.15);
}
.dropdown:checked ~ .section-dropdown {
  opacity: 1;
  pointer-events: auto;
  transform: translateY(0);
}
.section-dropdown:before {
  position: absolute;
  top: -20px;
  left: 0;
  width: 100%;
  height: 20px;
  content: "";
  display: block;
  z-index: 1;
}
.section-dropdown:after {
  position: absolute;
  top: -7px;
  left: 235;
  width: 0;
  height: 0;
  border-left: 8px solid transparent;
  border-right: 8px solid transparent;
  border-bottom: 8px solid white;
  content: "";
  display: block;
  z-index: 2;
  transition: all 200ms linear;
}
.dark-light:checked ~ .sec-center .section-dropdown:after {
  border-bottom: 8px solid #fff;
}

.drp_link {
  position: relative;
  color: #203aa6;
  transition: all 200ms linear;
  font-family: "Roboto", sans-serif;
  font-weight: 500;
  font-size: 15px;
  border-radius: 2px;
  padding: 5px 0;
  padding-left: 20px;
  padding-right: 15px;
  margin: 2px 0;
  text-align: left;
  text-decoration: none;
  display: -ms-flexbox;
  display: flex;
  -webkit-align-items: center;
  -moz-align-items: center;
  -ms-align-items: center;
  align-items: center;
  justify-content: space-between;
  -ms-flex-pack: distribute;
}
.dark-light:checked ~ .sec-center .section-dropdown .drp_link {
  color: #102770;
}
.drp_link:hover {
  color: #102770;
  background-color: #ffeba7;
}
.dark-light:checked ~ .sec-center .section-dropdown .drp_link:hover {
  color: #ffeba7;
  background-color: #102770;
}
.drp_link .uil {
  font-size: 22px;
}
.dropdown-sub:checked + label,
.dropdown-sub:not(:checked) + label {
  position: relative;
  color: #fff;
  transition: all 200ms linear;
  font-family: "Roboto", sans-serif;
  font-weight: 500;
  font-size: 15px;
  border-radius: 2px;
  padding: 5px 0;
  padding-left: 20px;
  padding-right: 15px;
  text-align: left;
  text-decoration: none;
  display: -ms-flexbox;
  display: flex;
  -webkit-align-items: center;
  -moz-align-items: center;
  -ms-align-items: center;
  align-items: center;
  justify-content: space-between;
  -ms-flex-pack: distribute;
  cursor: pointer;
}
.dropdown-sub:checked + label .uil,
.dropdown-sub:not(:checked) + label .uil {
  font-size: 22px;
}
.dropdown-sub:not(:checked) + label .uil {
  transition: transform 200ms linear;
}
.dropdown-sub:checked + label .uil {
  transform: rotate(135deg);
  transition: transform 200ms linear;
}
.dropdown-sub:checked + label:hover,
.dropdown-sub:not(:checked) + label:hover {
  color: #102770;
  background-color: #ffeba7;
}
.dark-light:checked ~ .sec-center .section-dropdown .for-dropdown-sub {
  color: #102770;
}
.dark-light:checked ~ .sec-center .section-dropdown .for-dropdown-sub:hover {
  color: #ffeba7;
  background-color: #102770;
}

.section-dropdown-sub {
  position: relative;
  display: block;
  width: 100%;
  pointer-events: none;
  opacity: 0;
  max-height: 0;
  padding-left: 10px;
  padding-right: 3px;
  overflow: hidden;
  transition: all 200ms linear;
}
.dropdown-sub:checked ~ .section-dropdown-sub {
  pointer-events: auto;
  opacity: 1;
  max-height: 999px;
}
.section-dropdown-sub a {
  font-size: 14px;
}
.section-dropdown-sub a .uil {
  font-size: 20px;
}
.logo {
  position: fixed;
  top: 50px;
  left: 40px;
  display: block;
  z-index: 11000000;
  background-color: transparent;
  border-radius: 0;
  padding: 0;
  transition: all 250ms linear;
}
.logo:hover {
  background-color: transparent;
}
.logo img {
  height: 26px;
  width: auto;
  display: block;
  transition: all 200ms linear;
}
.dark-light:checked ~ .logo img {
  filter: brightness(10%);
}

@media screen and (max-width: 991px) {
  .logo {
    top: 30px;
    left: 20px;
  }
  .dark-light:checked + label,
  .dark-light:not(:checked) + label {
    top: 20px;
    right: 20px;
  }

}
.humberger {
        width: 35px;
        height: 5px;
        background-color: black;
        margin: 6px 0;
        background-color: #ffe969;
    }
    @media only screen and (max-width: 600px) {
      #nav-image{
        width: 114% !important;
      }
      .section-dropdown:after {
        left:27px;
      }
      .section-dropdown {
        right:-54px
      }
      .for-dropdown{
        left:-75 !important;
      }
 
}
.dropdown-item{
    line-height:20px;
}
.for-dropdown{
    left:100px ;
}
</style>
<nav class="navbar t" style="background-color: #203aa6 ;padding-right:30px;">
    <span class="navbar-brand mb-0 h1" style="color:#ffc43b"><a href="https://motortrade.com.ph/"><img id="nav-image" src="<?=base_url()?>assets/forms_image/logo_1.png" style="width: 26%;" alt="" srcset=""></a></span>
    <span class="navbar-text">
       	<div class="sec-center"> 	
	  	<input class="dropdown" type="checkbox" id="dropdown" name="dropdown" hidden/>
	  	<label class="for-dropdown " for="dropdown" >  
          <i class="fa fa-bars" aria-hidden="true" style="font-size:40px;color:#e7c114;"></i>
            <i class="uil uil-arrow-down"></i></label>
  		<div class="section-dropdown p-2"> 
  			
              <a class="dropdown-item drp_link" href="https://motortrade.com.ph/">Motortrade Official Website</a>
                <a class="dropdown-item drp_link" href="https://cportal.motortrade.com.ph/">Customer Portal</a>
                <hr>
                <a class="dropdown-item drp_link" href="<?=base_url()?>inquiry?src=MTgxMg">Inquiry Form</a>
                <a class="dropdown-item drp_link" href="<?=base_url()?>loan?src=MTgxMg">Loan Application Form</a>
                <a class="dropdown-item drp_link" href="<?=base_url()?>ltrs">Learn To Ride Safely Registration</a>
                <a class="dropdown-item drp_link" href="<?=base_url()?>test-ride">Test Ride Registration</a>
                <a class="dropdown-item drp_link" href="<?=base_url()?>service">Service Appointment Form</a>
                <a class="dropdown-item drp_link" href="<?=base_url()?>big-bike">Big Bike Reservation Form</a>
                <hr>
                <a class="dropdown-item mb-2 drp_link" href="<?=base_url()?>customercare">Customer Care</a>
  		</div>
  	</div>
    </span>
</nav>
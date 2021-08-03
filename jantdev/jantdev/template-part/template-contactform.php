 <section class="contact">
   <div class="success_message"><h4>The Contact form has been sendt</h4><p>We will get back to you asap</p></div>
           <div class="error_message"><h4>There has been a error</h4><p>Try again later</p></div>
              
              <form class="contactForm" id="contactForm">
              <div class="contact-info">
              <h3>Let's get started</h3>
              <p>You can contact me and descript your project/job, by filling out the form below, you can also contact me by email:
                <a href="mailto:hireme@jantdev.com" class="btn--maillink"
                  >hireme@jantdev.com
                </a>
              </p>
              </div>
           
              <div class="grid-contact">
                  <label class="email">Email</label>
                  <label class="name">Name</label>
                  <input
                    type="email"
                    class="iemail"
                    name="email"
                    value="hireme@jantdev.com"
                    placeholder="Enter a validemail address"
                    required
                  />
                  <input
                    type="text"
                    class="iname"
                    name="name"
                     value="Jan Jensen"
                     required
                    placeholder="Enter your name"
                  />
                  <label class="message">Message</label>
                  <textarea
                    class="imessage"
                    name="message"
                    placeholder="Enter your message"
                    required
                  >This is a massage</textarea>
                  <div class="submit-container">
                    <button type="submit" class="btn--link btn-submit">
                      Submit
                    </button>
                  </div>
                </div>
              </form>
            </section>


   <script>
(function($){
   $(".success_message").hide();
    $(".error_message").hide();
      $("#contactForm").submit(function(e){
        e.preventDefault();
        var endpoint = "<?php echo admin_url('admin-ajax.php');?>";
        var payload = $("#contactForm").serialize();
        var formData = new FormData();
        formData.append("action","contactForm");
        formData.append("contactForm",payload);
        $.ajax(endpoint,{
          type:"post",
          data:formData,
          processData:false,
          contentType:false,
          success:function(res){
            $(".contactForm").hide();
            $(".success_message").show();
          },
          error:function(error){
            console.log(error);
            $(".contactForm").hide();
            $(".error_message").show();
          }
        })
      })

})(jQuery)

   </script>         
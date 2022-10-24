<?php $this->extends("layouts.main", "content") ;?> 

<main>
    <div class="top">
        <div class="container">
            <div class="logo">
                Spoot
            </div>
            <div class="header">
                <div class="caption">A place to buy rocket things</div>
                <ul>
                    <li><a href="/">Home</a></li>
                    <li><a href="/register">Register</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="under">
        <div class="container">
            <form method="post" action="<?php print  $router->route('show-register-form')  ?>" class="form text-center pt-5" autocomplete="off">
                <h1 class="text-xl font-semibold mb-4">Register</h1>
            
                <input name="token"  type="hidden"  value="<?php print  $csrfToken ?>" />
                
                <div class="form-group m-3">
                    <label for="name" class="flex flex-col w-full">Name: </label>
                    <input class="form-control " id="name" name="name"  type="text"   placeholder="Alex" />
                </div>
               
                <div class="form-group m-3">
                     <label for="email" class="flex flex-col w-full">Email: </label>
                     <input class="form-control" id="email" name="email"  type="text"  placeholder="alex.42@gmail.com" />
                </div>
               
                <div class="form-group m-3">
                    <label for="password" class="flex flex-col w-full">Password: </label>
                    <input class="form-control" id="password" name="password"    type="password"/>
                </div>
               
                    <button type="submit" class="btn btn-secondary m-3"  >Register</button>
            </form>
        </div>
    </div>
</main>


<?php if($errors): ?>
<script>
    
    <?php foreach($errors as $attr => $error) : ?>

        let <?php print $attr ?>Feedback = document.createElement("div")
        <?php print $attr ?>Feedback.setAttribute("class","text-danger")

        <?php print $attr ?>Feedback.textContent = "<?php print  $error  ?>"
        document.getElementById("<?php print  $attr  ?>").classList.add('is-invalid');
        document.getElementById("<?php print  $attr  ?>").after(<?php print $attr ?>Feedback);

    <?php endforeach; ?>
    <?php unset($_SESSION["errors"]) ?>
        
</script>
<?php endif; ?>
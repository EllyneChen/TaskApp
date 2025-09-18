<?php
class forms{
    private function submit_button($value){
        echo "<input type='submit' value='{$value}' class='btn btn-primary'>";
    }

    public function signup(){
        ?>
        <h2>Create Your Pet's Paw-tfolio!</h2>
        <form action='mail.php' method='post'>
            <div class="form-group">
                <label for='petName'>Pet's Name:</label>
                <input type='text' id='petName' name='petName' required class="form-control">
            </div>
            
            <div class="form-group">
                <label for='petType'>Type of Pet:</label>
                <select id='petType' name='petType' required class="form-control">
                    <option value="">Select your pet type</option>
                    <option value="Dog">Dog</option>
                    <option value="Cat">Cat</option>
                    <option value="Bird">Bird</option>
                    <option value="Fish">Fish</option>
                    <option value="Reptile">Reptile</option>
                    <option value="Small Mammal">Small Mammal</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for='petBreed'>Breed (optional):</label>
                <input type='text' id='petBreed' name='petBreed' class="form-control">
            </div>
            
            <div class="form-group">
                <label for='ownerName'>Your Name (Owner):</label>
                <input type='text' id='ownerName' name='ownerName' required class="form-control">
            </div>
            
            <div class="form-group">
                <label for='email'>Your Email:</label>
                <input type='email' id='email' name='email' required class="form-control">
               
            </div>
            
            <?php $this->submit_button('Create Paw-tfolio'); ?> 
            <a href="login.php" class="btn btn-link">Already have a paw-tfolio? Log in</a>
        </form>
        <?php
    }

    public function login(){
        ?>
        <h2>Access Your Pet's Paw-tfolio</h2>
        <form action='submit_login.php' method='post'>
            <div class="form-group">
                <label for='email'>Your Email:</label>
                <input type='email' id='email' name='email' required class="form-control">
            </div>
            
            <div class="form-group">
                <label for='password'>Password:</label>
                <input type='password' id='password' name='password' required class="form-control">
            </div>
            
            <?php $this->submit_button('Log In'); ?> 
            <a href="index.php" class="btn btn-link">Create a new Paw-tfolio</a>
        </form>
        <?php
    }
}
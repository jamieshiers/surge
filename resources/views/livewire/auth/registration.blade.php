<form wire:submit.prevent="register">

<div>
    <label for="name">name</label>    
    <input wire:model="name" type="text" id="name" name="name">
    @error('name') <span>{{ $message }}</span> @enderror
</div>

<div>
    <label for="email">email</label>    
    <input wire:model="email" type="text" id="email" name="email">
    @error('email') <span>{{ $message }}</span> @enderror
</div>

<div>
    <label for="password">password</label>
    <input wire:model="password" type="password" id="password" name="password">
    @error('password') <span>{{ $message }}</span> @enderror
</div>

<div>
    <label for="passwordConfirmation">passwordConfirmation</label>
    <input wire:model="passwordConfirmation" type="password" id="passwordConfirmation" name="passwordConfirmation">
</div>

<input type="submit" value="register">


</form>





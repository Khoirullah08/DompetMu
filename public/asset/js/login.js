 function togglePassword() {
     const input = document.getElementById('pwdInput');
     const eyeOff = document.getElementById('eyeOff');
     const eyeOn = document.getElementById('eyeOn');
     if (input.type === 'password') {
         input.type = 'text';
         eyeOff.style.display = 'none';
         eyeOn.style.display = 'block';
     } else {
         input.type = 'password';
         eyeOff.style.display = 'block';
         eyeOn.style.display = 'none';
     }
 }
import * as React from 'react';
import { useState } from 'react';
import { useSignIn } from 'react-auth-kit';
import { useNavigate } from 'react-router-dom';
// @mui
import { FormHelperText, Link, Stack, IconButton, InputAdornment, TextField, Checkbox } from '@mui/material';
import { LoadingButton } from '@mui/lab';
// components
import Iconify from '../../../components/iconify';

import axios from "../../../axios-instance";
// ----------------------------------------------------------------------

export default function SignUpForm() {
  
  const navigate = useNavigate();
  const signIn = useSignIn();
  const [username, setUserName] = useState("");
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [helperText, setHelperText] = useState('');
  const [errors, setErrors] = useState({});
  const [showPassword, setShowPassword] = useState(false);

  const handleEntryChange = (event: React.ChangeEvent<HTMLInputElement>) => {setHelperText('');};

  const handleClick = (event: React.FormEvent<HTMLFormElement>)  => {
    
    event.preventDefault();
    const errors = validateForm();
    setErrors(errors);
    
    if (Object.keys(errors).length === 0)
    {
      axios.post("/auth/signup", {
        username,
        email,
        password,
      })
      .then((res) =>
      {
        if (res.data.status === 'success')
        {
          signIn({
            token: res.data.data.access_token,
            expiresIn: 43200000,
            tokenType: "Bearer",
            authState: res.data.data.user
        })
          // Redirect to the home page
          navigate('/dashboard', { replace: true });
        }
        else
        {
          // Show an error message
          setHelperText(res.response.data.message);  
        }
      })
      .catch((err) => {
        // Show an error message
        setHelperText(err.response.data.message);  
      });
    }
  };

  const validateForm = () => {
    const errors = {};

    if (!username) errors.username = 'User Name is required.';
    if (!email) errors.email = 'Email is required.';
    else if (!/\S+@\S+\.\S+/.test(email)) errors.email = 'Email is invalid.';

    if (!password) errors.password = 'Password is required.';
    else if (password.length < 8) errors.password = "Password Should be more than 8 characters";

    return errors;
  };

  return (
    <>
      <Stack spacing={3}>
        <TextField
          id="username"
          name="username"
          label="User Name"
          value={username}
          onInput={ e=>setUserName(e.target.value)}
          onChange={handleEntryChange}
          required
        />
        {errors.username && <span>{errors.username}</span>}
        
        <TextField
          id="email"
          name="email"
          label="Email address"
          value={email}
          onInput={ e=>setEmail(e.target.value)}
          onChange={handleEntryChange}
          required
        />
        {errors.email && <span>{errors.email}</span>}

        <TextField
          id="password"
          name="password"
          label="Password"
          value={password}
          onInput={ e=>setPassword(e.target.value)}
          type={showPassword ? 'text' : 'password'}
          onChange={handleEntryChange}
          required
          InputProps={{
            endAdornment: (
              <InputAdornment position="end">
                <IconButton onClick={() => setShowPassword(!showPassword)} edge="end">
                  <Iconify icon={showPassword ? 'eva:eye-fill' : 'eva:eye-off-fill'} />
                </IconButton>
              </InputAdornment>
            ),
          }}
        />
        {errors.password && <div className="error"> {errors.password} </div> }
        
      </Stack>
      <FormHelperText>{helperText}</FormHelperText>      

      <LoadingButton fullWidth size="large" type="submit" variant="contained" onClick={handleClick}>
        Sign Up
      </LoadingButton>
    </>
  );
}

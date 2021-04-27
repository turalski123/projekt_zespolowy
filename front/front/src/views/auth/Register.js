import React from "react";
// @material-ui/core components
import { makeStyles } from "@material-ui/core/styles";
import { useTheme } from "@material-ui/core/styles";
import Box from "@material-ui/core/Box";
import Button from "@material-ui/core/Button";
import Card from "@material-ui/core/Card";
import CardContent from "@material-ui/core/CardContent";
import FilledInput from "@material-ui/core/FilledInput";
import FormControl from "@material-ui/core/FormControl";

import Grid from "@material-ui/core/Grid";
import InputAdornment from "@material-ui/core/InputAdornment";
// @material-ui/icons components
import Email from "@material-ui/icons/Email";
import Lock from "@material-ui/icons/Lock";
import School from "@material-ui/icons/School";

// core components
import componentStyles from "assets/theme/views/auth/register.js";
import axios from "axios";

const useStyles = makeStyles(componentStyles);


async function RegisterCall(data){


    const content = {
      username: data.username,
      password: data.password,
      email: data.email,
    }


    var result = false;
    axios.post('/api/v1/register',content).then((response)=>{
      console.log(response);
      result=response
    });
  return new Promise((resolve, reject) => {
    setTimeout(function() {
      result != false ? resolve(result) : reject(false);
    }, 700);
  })

};
function validateFormData(){
  var username = document.getElementById('username').value;
  var password = document.getElementById('password').value;
  var email = document.getElementById('email').value;

  if(username!='' && password!='' && email!=''){

    var data ={
      username:username,
      password:password,
      email:email,
    }
    RegisterCall(data).then((response)=>{
      if(response.error==null){
        alert('Utworzono');
      }else{
        alert ("Błąd:<br>"+response.error)
      }
    })
  }


}

function Register() {
  const classes = useStyles();
  const theme = useTheme();
  return (
    <>
      <Grid item xs={12} lg={6} md={8}>
        <Card classes={{ root: classes.cardRoot }}>

          <CardContent classes={{ root: classes.cardContent }}>
            <Box
              color={theme.palette.gray[600]}
              textAlign="center"
              marginBottom="1.5rem"
              marginTop=".5rem"
              fontSize="1rem"
            >
              <Box fontSize="80%" fontWeight="400" component="small">
                {"Create new account"}

              </Box>
            </Box>
            <FormControl
              variant="filled"
              component={Box}
              width="100%"
              marginBottom="1.5rem!important"
            >
              <FilledInput
                 id={'username'}
                autoComplete="off"
                type="text"
                placeholder="Name"
                startAdornment={
                  <InputAdornment position="start">
                    <School />
                  </InputAdornment>
                }
              />
            </FormControl>
            <FormControl
              variant="filled"
              component={Box}
              width="100%"
              marginBottom="1.5rem!important"
            >
              <FilledInput
                  id={'email'}
                autoComplete="off"
                type="email"
                placeholder="Email"
                startAdornment={
                  <InputAdornment position="start">
                    <Email />
                  </InputAdornment>
                }
              />
            </FormControl>
            <FormControl
              variant="filled"
              component={Box}
              width="100%"
              marginBottom="1.5rem!important"
            >
              <FilledInput
                  id={'password'}
                autoComplete="off"
                type="password"
                placeholder="Password"
                startAdornment={
                  <InputAdornment position="start">
                    <Lock />
                  </InputAdornment>
                }
              />
            </FormControl>


            <Box textAlign="center" marginTop="1.5rem" marginBottom="1.5rem">
              <Button color="primary" variant="contained" onClick={()=>
                validateFormData()}>
                Create account
              </Button>
            </Box>
          </CardContent>
        </Card>
        <Grid container component={Box} marginTop="1rem">
          <Grid item xs={6} component={Box} textAlign="right">
            <a
                href="/auth/login"

                className={classes.footerLinks}
            >
              Login with existing credentials
            </a>
          </Grid>
        </Grid>
      </Grid>
    </>
  );
}

export default Register;

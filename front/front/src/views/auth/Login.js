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
// core components
import componentStyles from "assets/theme/views/auth/login.js";
import axios from "axios";

const useStyles = makeStyles(componentStyles);


async function LoginCall(data){


  const content = {
    username: data.username,
    password: data.password,
  }


  var result = false;
  axios.post('/api/v1/login',content).then((response)=>{
    console.log(response);
    result=response
  });
  return new Promise((resolve, reject) => {
    setTimeout(function() {
      result != false ? resolve(result) : reject(false);
    }, 10000);
  })

};
function validateFormData(){
  var username = document.getElementById('username').value;
  var password = document.getElementById('password').value;

  if(username!='' && password!='' ){

    var data ={
      username:username,
      password:password,
    }
    LoginCall(data).then((response)=>{
      if(response.error==null){
        alert('Zalogowano');
      }else{
        alert ("Błąd:<br>"+response.error)
      }
    })
  }


}

function Login() {
  const classes = useStyles();
  const theme = useTheme();
  return (
    <>
      <Grid item xs={12} lg={5} md={7}>
        <Card classes={{ root: classes.cardRoot }}>
          <CardContent classes={{ root: classes.cardContent }}>
            <Box
              color={theme.palette.gray[600]}
              textAlign="center"
              marginBottom="1rem"
              marginTop=".5rem"
              fontSize="1rem"
            >
              <Box fontSize="80%" fontWeight="400" component="small">
                Sign in
              </Box>
            </Box>
            <FormControl
              variant="filled"
              component={Box}
              width="100%"
              marginBottom="1rem!important"
            >
              <FilledInput
                  id={'username'}
                autoComplete="off"
                type="text"
                placeholder="Username"
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
              marginBottom="1rem!important"
            >
              <FilledInput
                  id={"password"}
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
              <Button  onClick={()=>validateFormData()} color="primary" variant="contained">
                Sign in
              </Button>
            </Box>
          </CardContent>
        </Card>
        <Grid container component={Box} marginTop="1rem">
          <Grid item xs={6} component={Box} textAlign="right">
            <a
              href="/auth/register"

              className={classes.footerLinks}
            >
              Create new account
            </a>
          </Grid>
        </Grid>
      </Grid>
    </>
  );
}

export default Login;

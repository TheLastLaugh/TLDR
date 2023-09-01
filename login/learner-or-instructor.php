<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../styles/welcome.css" />
    <script
      src="https://kill.fontawesome.com/c9f5871d83.js"
      crossorigin="anonymous"
    ></script>
    <title>Welcome</title>
  </head>
  <body>
    <header class="header">
      <a href="#" class="logo" class="fa-solid fa-globe"><i>TLDR</i> </a>
    </header>

    <section class="home">
      <div class="content">
        <h2>Welcome</h2>
        <p>
          Welcome to the TLDR. Online serive to input your driving lessons and
          hours at ease.
        </p>
        <a href="#">Get Started </a>
      </div>
      <div class="login">
        <h2>Sign In</h2>
        <form action="#">
          <div class="input-box">
            <span class="icon">
              <i class="fa-solid fa-envelope"></i>
            </span>
            <input
              type="text"
              class="input"
              id="user-input"
              placeholder="Enter your email"
              autocomplete="off"
              required
            />
          </div>
          <div class="input-box">
            <span class="icon">
              <i class="fa-solid fa-lock"></i>
              <input
                type="password"
                class="input"
                id="user-input"
                placeholder="Enter your password"
                autocomplete="off"
                required
              />
            </span>
          </div>
          <div class="remember-forgot">
            <label> <input type="checkbox" />Remember me</label>
            <a href="#">Forgot Password?</a>
          </div>
          <button type="submit">Login</button>
          <div class="register-link">
            <p><strong>Not a member?</strong></p>
            <br />

            <a
              href="https://account.sa.gov.au/auth/realms/sa/protocol/openid-connect/registrations?client_id=ezyreg-account&redirect_uri=https%3A%2F%2Faccount.ezyreg.sa.gov.au%2Faccount%2Fhome.htm&response_type=code"
              >Sign up now</a
            >
          </div>
        </form>
      </div>
    </section>
  </body>
</html>
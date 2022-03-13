<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Bootstrap grid</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/media.css') }}">
   
</head>

<body>
    <header id="header" class="py-4">
        <div class="container">
            <div class="header mb-3 row align-items-center justify-content-between">
                <div class="logo col-md-auto">
                    <h1 class="text-light mb-1">Basic</h1>
                    <p class="text-light mb-0">Free HTML5 Website Template</p>
                </div>
                <div class="search col-md-auto">
                    <form action="" method="GET" class="row gx-1">
                        <div class="col-auto">
                            <input name="keyword" required class="form-control" type="text"
                                placeholder="Search Our Website" />
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-warning">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
            <nav id="menu" class="p-4">
                <ul class="d-flex">
                    <li><a href="home">Home</a></li>
                    <li><a href="about">About</a></li>
                    <li><a href="product">Product</a></li>
                    <li><a href="news">News</a></li>
                    <li><a href="contact">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <div class="container py-4">

            <form action='form' method="POST" class="my-3">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                    <input name="email" type=" email" required class="form-control" id="exampleInputEmail1"
                        aria-describedby="emailHelp">
                    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input name="text" type="password" class="form-control" id="exampleInputPassword1">
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                </div>

                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>

            <div class="about row g-0">
                <div class="des-about col-xl-4 col-lg-6 col-md-12 p-4">
                    <h2 class="text-light">What is Lorem Ipsum?</h2>
                    <p class="text-light">Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                        Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown
                        printer took a galley of type and scrambled it to make a type specimen book. </p>
                    <div class="text-end">
                        <a class="text-warning-c fw-bold" href="">Read More &#187;</a>
                    </div>
                </div>
                <div class="img-about col-xl-8 col-lg-6 col-md-12">
                    <img class="img-fluid" src="https://via.placeholder.com/1574x770.jpg/353535" alt="img" />
                </div>
            </div>
            <div class="content mt-5 row">
                <div class="left-content col-lg-6">
                    <h3>
                        What is Lorem Ipsum?
                    </h3>
                    <p>Lorem Ipsum is simply dummy text of the printing and <strong
                            class="text-warning-c fw-bold">typesetting industry</strong>. Lorem Ipsum has been the
                        industry's standard dummy text ever since the 1500s</p>
                    <p>Lorem Ipsum is simply dummy text of the printing and <strong
                            class="text-warning-c fw-bold">typesetting industry</strong>. Lorem Ipsum has been the
                        industry's standard dummy text ever since the 1500s</p>
                </div>
                <div class="right-content col-lg-6">
                    <div class="row g-3 g-md-5">
                        <div class="items col-md-4">
                            <div class="border p-1">
                                <img class="img-fluid" src="https://via.placeholder.com/500x500.jpg/353535" alt="img" />
                            </div>
                        </div>
                        <div class="items col-md-4">
                            <div class="border p-1">
                                <img class="img-fluid" src="https://via.placeholder.com/500x500.jpg/353535" alt="img" />
                            </div>
                        </div>
                        <div class="items col-md-4">
                            <div class="border p-1">
                                <img class="img-fluid" src="https://via.placeholder.com/500x500.jpg/353535" alt="img" />
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <a href="" class="readmore text-uppercase text-warning-c fw-bold">View our image galley here
                            &#187;</a>
                    </div>
                </div>
            </div>
            <div class="w-100 line-main mt-4"></div>
        </div>
    </main>
    <footer id="footer">
        <div class="footer py-4">
            <div class="container">
                <div class="row g-3 g-md-5">
                    <div class="col-footer col-lg-3 col-md-6">
                        <h3 class="text-uppercase fst-italic mb-4">From the blog</h3>
                        <h4>Post Title</h4>
                        <p>Lorem Ipsum is simply dummy text of the printing and <strong
                                class="text-warning-c fw-bold">typesetting industry</strong>. Lorem Ipsum has been the
                            industry's standard dummy text ever since the 1500s</p>
                        <div class="text-end">
                            <a class="text-warning-c fw-bold" href="">Read More &#187;</a>
                        </div>
                    </div>
                    <div class="col-footer col-lg-3 col-md-6">
                        <h3 class="text-uppercase fst-italic mb-4">Quick Links</h3>
                        <ul class="mb-0">
                            <li><a href="" class="text-warning-c fw-bold">Lorem Ipsum is simply</a></li>
                            <li><a href="" class="text-warning-c fw-bold">Lorem Ipsum is simply</a></li>
                            <li><a href="" class="text-warning-c fw-bold">Lorem Ipsum is simply</a></li>
                            <li><a href="" class="text-warning-c fw-bold">Lorem Ipsum is simply</a></li>
                            <li><a href="" class="text-warning-c fw-bold">Lorem Ipsum is simply</a></li>
                        </ul>
                    </div>
                    <div class="col-footer col-lg-6 col-md-12">
                        <h3 class="text-uppercase fst-italic mb-4">About us</h3>
                        <div class="about_footer row">
                            <div class="img_footer col-md-3 col-sm-5">
                                <div class="border p-1">
                                    <img class="img-fluid" src="https://via.placeholder.com/500x500.jpg/353535"
                                        alt="img" />
                                </div>
                            </div>
                            <div class="des_footer col-md-9 col-sm-7">
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                                    Ipsum has been the industry's standard dummy text ever since the 1500s Lorem Ipsum
                                    is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
                                    the industry's standard dummy text ever since the 1500s</p>
                                <div class="text-end">
                                    <a class="text-warning-c fw-bold" href="">Read More &#187;</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright py-3">
            <div class="container d-flex justify-content-between">
                <p class="text-light mb-0">Copyright @2022 by samle</p>
                <p class="text-light mb-0">Template</p>
            </div>
        </div>
    </footer>
</body>

</html>
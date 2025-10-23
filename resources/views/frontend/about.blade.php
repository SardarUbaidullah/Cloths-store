@extends('frontend.layouts.main')
@section('main-container')
	<!-- Title page -->
	<section class="bg-img1 about-page txt-center p-lr-15 p-tb-92" style="background: url({{url('frontend/images/about.png')}}); background-size: cover;margin-top:0px; ">
		<h2 class="ltext-105 cl0 txt-center">
			About
		</h2>
	</section>


	<!-- Content page -->
	<section class="bg0 p-t-75 p-b-120">
		<div class="container">
			<div class="row p-b-148">
<div class="col-md-7 col-lg-8">
	<div class="p-t-7 p-r-85 p-r-15-lg p-r-0-md">
		<h3 class="mtext-111 cl2 p-b-16">
			Our Story
		</h3>

		<p class="stext-113 cl6 p-b-26">
			Every brand has a beginning — ours started with a sketchbook, a sewing machine, and a dream to create clothing that celebrates the strength and softness of every woman. [Bin Zaman Store] grew from a quiet passion into a statement of style for those who value simplicity with soul.
		</p>

		<p class="stext-113 cl6 p-b-26">
			Our journey hasn’t just been about fashion — it’s been about forming connections. We believe every piece should feel like it was made for you: with care, with intention, and with the kind of elegance that doesn’t try too hard. From timeless tailoring to soft flowing fabrics, our collections are made to become part of your personal story.
		</p>

		<div class="bor16 p-l-29 p-b-9 m-t-22">
			<p class="stext-114 cl6 p-r-40 p-b-11">
				Clothes aren’t going to change the world. The women who wear them will. Every outfit should speak your truth — effortlessly and unapologetically.
			</p>
			<span class="stext-111 cl8">
				– Anne Klein
			</span>
		</div>


	</div>
</div>

				<div class="col-11 col-md-5 col-lg-4 m-lr-auto">
					<div class="how-bor1 ">
						<div class="hov-img0">
							<img src="{{url('frontend/images/about-1.webp')}}" alt="IMG">
						</div>
					</div>
				</div>
			</div>

			<div class="row">
			<div class="order-md-2 col-md-7 col-lg-8 p-b-30">
	<div class="p-t-7 p-l-85 p-l-15-lg p-l-0-md">
		<h3 class="mtext-111 cl2 p-b-16">
			Our Mission
		</h3>

		<p class="stext-113 cl6 p-b-26">
			At [Bin Zaman Store], our mission is to empower every woman to express her unique style with confidence and grace. We believe fashion is more than clothing — it's a reflection of personality, mood, and ambition. From elegant everyday essentials to head-turning statement pieces, we curate collections that celebrate femininity in all its beautiful forms. Our goal is to deliver not just garments, but an experience — one that inspires joy, self-expression, and effortless elegance in every stitch.
		</p>

		<div class="bor16 p-l-29 p-b-9 m-t-22">
			<p class="stext-114 cl6 p-r-40 p-b-11">
				Fashion is about dreaming and making other people dream. When a woman feels good in what she’s wearing, it becomes more than just style — it becomes her confidence, her power, her voice.
			</p>

			<span class="stext-111 cl8">
				– Donatella Versace
			</span>
		</div>
	</div>
</div>


				<div class="order-md-1 col-11 col-md-5 col-lg-4 m-lr-auto p-b-30">
					<div class="how-bor2">
						<div class="hov-img0">
<img src="{{ asset('frontend/images/about-2.webp') }}" alt="IMG">
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

@endsection





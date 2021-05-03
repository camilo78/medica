<!-- partial:partials/_footer.html -->
<footer class="footer">
    <div class="d-sm-flex justify-content-center justify-content-sm-between">
        <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © <a href="https://emprende.dev/"> Emprende en la Web</a> {{now()->format('Y')}}</span>
        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"><spam class="text-info"> {{ env('APP_NAME') }} V{{ env('VERSION') }}.</spam> {{ env('DESCRIPTION') }}</span>
    </div>
</footer>
<!-- partial -->

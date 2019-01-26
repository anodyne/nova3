<div class="layout-auth-two-pane">
    <section>
        <aside>
            <img src="/themes/pulsar/design/images/Early_2270s_Starfleet.svg" alt="" class="block mx-auto h-40">

            <h2 class="my-6 text-3xl text-grey-200 text-center">Welcome to Nova 3!</h2>

            <p class="leading-loose text-grey-400 text-lg font-medium mb-12 text-center">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Consequuntur dolore non tempora dolor ut. Nobis tenetur unde dolores fuga in, qui nihil, eveniet similique tempora quam neque at doloremque. Dolores?</p>

            <div class="controls">
                <a href="#" class="button button-secondary button-large">
                    <app-icon name="edit" class="mr-3"></app-icon>
                    Join Today
                </a>

                <a href="#" class="button button-secondary button-large">
                    <app-icon name="search" class="mr-3"></app-icon>
                    Explore
                </a>
            </div>
        </aside>

        <main>
            {!! $template ?? false !!}
        </main>
    </section>
</div>
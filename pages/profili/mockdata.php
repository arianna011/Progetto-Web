<?php


$avatarSrc ??= 'https://picsum.photos/1000/1000?random=0';
$infos ??= array_fill(0, 4, "Lorem ipsum");
$description ??= 
'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut eget ante tincidunt, efficitur felis
ut, rutrum metus.
Ut egestas gravida metus at suscipit. Suspendisse semper nec odio quis suscipit. Praesent
dignissim efficitur erat,
vel posuere leo scelerisque quis. Nunc accumsan venenatis lorem, sed auctor enim consectetur at.
Praesent elit leo,
iaculis in nunc nec, iaculis ullamcorper nisl. Morbi porta dolor sapien, tristique varius odio
maximus eget.
Nam dignissim quam nulla, vel cursus arcu porta in. Curabitur porta nibh eu dolor tempor
vulputate. Nulla lacinia
vulputate tellus quis maximus. Nulla in velit semper, tempus velit vitae, ultricies risus. Nunc
massa justo,
varius ut nibh et, hendrerit molestie enim.
Phasellus tristique ligula eget enim sollicitudin, et commodo erat venenatis. Quisque viverra
ante augue,
quis facilisis ligula egestas in. Suspendisse potenti. Morbi non ante mi. Morbi finibus, eros
nec tincidunt faucibus,
dolor odio egestas purus, vel sollicitudin mauris neque vitae sapien. Maecenas tempor nisi
lobortis luctus luctus.
Donec finibus aliquam justo, vel efficitur elit varius aliquam.';

if(!isset($imgs))
    for ($i = 0; $i < 10; $i++)
        $imgs[$i] = "https://picsum.photos/1000/1000?random=".($i+1);

?>
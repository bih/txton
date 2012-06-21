txton is a new REST format designed for speed
====================

**txton** is a new REST format designed by Bilawal Hameed which aims to implement speed and efficiency into API-based data transfer.

Our solution is around 40% smaller than JSON, and around 85% smaller than XML. These are dramatic, especially when considering in such large scales or when dealing with multiple large requests.

Status: **Unstable, In Development**

Infrastructure
---------------------
txton works in two different ways.

When encoding, it only requires one array, but can be converted to two different types of results. One of which is the **structure** and the other being the **string**. The structure is used to decode the string, so therefore both are needed but each can be provided separately.

When decoding, both the structure and string obtained from encoding are required for a successful decode, and then results in the same output you would get from JSON or XML. Though JSON and XML are more stable and support multi-level encoding, txt on still provides a powerful infrastructure for even the most simplest of data transfers.

Use cases
---------------------
Companies which transfer data across two servers can use txton to save the structure to both servers, and then be able to transfer data using the txton REST format to increase performance and reduce transfer costs.

It can also be used as the traditional form of API usage, however the structure can be saved and updated every 24 hours which makes each API call faster to process and transfer. This requires more technical ability to understand our infrastructure, however with API libraries this would become less of an issue. 

Example code
---------------------
We have provided a test example in **example.php** however three functions are all you need to know of.

txton_encode( $array )
txton_structure( $array )
txton_decode( $array, $structure )

Have a play about with it! It's really fun.

About the Author
---------------------
![My logo](http://i.imgur.com/JHqEI.png "My logo")

Bilawal Hameed is a 19 year old web developer, entrepreneur and student from Manchester, UK.

I've been programming since I was 9 years old, and I love open source. I've decided that it's time that I give back to the community, and I have released my plugin for free and I have plenty of other plugins on the way.

You can find more about myself, my work and my vision over at [my website](http://www.bilawal.co.uk/).
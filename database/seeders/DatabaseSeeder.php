<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Book;
use App\Models\Copy;
use App\Models\Role;
use App\Models\User;
use App\Models\Author;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        

        $roleAdmin  = Role::create([
            'name' => 'Administrator',
            'description' => 'This is Administrator role. It has privilages to create, edit, delete and return the books. This role can create, edit or delete new author. It can see all the users and borrowed books.',
            'admin_permission' => true
            
        ]);

        $roleUser = Role::create([
            'name' => 'User',
            'description' => 'This is User role. It has privilages to see the catalogue and borrow choosen bookS (MAX 3)',
            'admin_permission' => false
            
        ]);

        $userAdmin = User::create([
            'role_id' => $roleAdmin['id'],
            'name' => 'Librarian',
            'email' => 'librarian@test.com',
            'password' => Hash::make('123456')
        ]);

        $user1 = User::create([
            'role_id' => $roleUser['id'],
            'name' => 'Johntra Volta',
            'email' => 'user1@test.com',
            'password' => Hash::make('123456')
        ]);

        $user2 = User::create([
            'role_id' => $roleUser['id'],
            'name' => 'Johnny Bee Good',
            'email' => 'user2@test.com',
            'password' => Hash::make('123456')
        ]);

        $author1 = Author::create([
            'name' => 'H.P.Lovecraft',
            'biography' => 'Howard Phillips Lovecraft (US: /ˈlʌvkræft/; August 20, 1890 – March 15, 1937) was an American writer of weird, science, fantasy, and horror fiction. He is best known for his creation of the Cthulhu Mythos.[a]

            Born in Providence, Rhode Island, Lovecraft spent most of his life in New England. After his fathers institutionalization in 1893, he lived affluently until his familys wealth dissipated after the death of his grandfather. Lovecraft then lived with his mother, in reduced financial security, until her institutionalization in 1919. He began to write essays for the United Amateur Press Association, and in 1913 wrote a critical letter to a pulp magazine that ultimately led to his involvement in pulp fiction. He became active in the speculative fiction community and was published in several pulp magazines. Lovecraft moved to New York City, marrying Sonia Greene in 1924, and later became the center of a wider group of authors known as the "Lovecraft Circle". They introduced him to Weird Tales, which would become his most prominent publisher. Lovecrafts time in New York took a toll on his mental state and financial conditions. He returned to Providence in 1926 and produced some of his most popular works, including The Call of Cthulhu, At the Mountains of Madness, The Shadow over Innsmouth, and The Shadow Out of Time. He would remain active as a writer for 11 years until his death from intestinal cancer at the age of 46.
            
            Lovecrafts literary corpus is based around the idea of cosmicism, which was simultaneously his personal philosophy and the main theme of his fiction. Cosmicism posits that humanity is an insignificant part of the cosmos, and could be swept away at any moment. He incorporated fantasy and science fiction elements into his stories, representing the perceived fragility of anthropocentrism. This was tied to his ambivalent views on knowledge. His works were largely set in a fictionalized version of New England. Civilizational decline also plays a major role in his works, as he believed that the West was in decline during his lifetime. Lovecrafts early political opinions were conservative and traditionalist; additionally, he held a number of racist views for much of his adult life. Following the Great Depression, Lovecraft became a socialist, no longer believing a just aristocracy would make the world more fair.
            
            Throughout his adult life, Lovecraft was never able to support himself from earnings as an author and editor. He was virtually unknown during his lifetime and was almost exclusively published in pulp magazines before his death. A scholarly revival of Lovecrafts work began in the 1970s, and he is now regarded as one of the most significant 20th-century authors of supernatural horror fiction. Many direct adaptations and spiritual successors followed. Works inspired by Lovecraft, adaptations or original works, began to form the basis of the Cthulhu Mythos, which utilizes Lovecrafts characters, setting, and themes.',
            'picture'=> 'logos/AHdtRe7iKYLEf9k1nyjT3ajpm7qzj0n0rgNkNbPw.jpg'
        ]);

        $author2 = Author::create([
            'name' => 'J. R. R. Tolkien',
            'biography' => 'John Ronald Reuel Tolkien CBE FRSL (/ˈruːl ˈtɒlkiːn/, ROOL TOL-keen;[a] 3 January 1892 – 2 September 1973) was an English writer and philologist. He was the author of the high fantasy works The Hobbit and The Lord of the Rings.

            From 1925 to 1945, Tolkien was the Rawlinson and Bosworth Professor of Anglo-Saxon and a Fellow of Pembroke College, both at the University of Oxford. He then moved within the same university to become the Merton Professor of English Language and Literature and Fellow of Merton College, and held these positions from 1945 until his retirement in 1959. Tolkien was a close friend of C. S. Lewis, a co-member of the informal literary discussion group The Inklings. He was appointed a Commander of the Order of the British Empire by Queen Elizabeth II on 28 March 1972.
            
            After Tolkiens death, his son Christopher published a series of works based on his fathers extensive notes and unpublished manuscripts, including The Silmarillion. These, together with The Hobbit and The Lord of the Rings, form a connected body of tales, poems, fictional histories, invented languages, and literary essays about a fantasy world called Arda and, within it, Middle-earth. Between 1951 and 1955, Tolkien applied the term legendarium to the larger part of these writings.
            
            While many other authors had published works of fantasy before Tolkien, the great success of The Hobbit and The Lord of the Rings led directly to a popular resurgence of the genre. This has caused him to be popularly identified as the "father" of modern fantasy literature—or, more precisely, of high fantasy.',
            'picture'=> 'logos/CoSEppCsIkNMa0zjaXCc2GxMBoFtuix81l3sKwhk.jpg'
        ]);

        $book1 = Book::create([
            'title' => 'At the Mountains of Madness',
            'author_id' => $author1['id'],
            'description' => 'The story is narrated in a first-person perspective by the geologist William Dyer, a professor at Arkhams Miskatonic University, aiming to prevent an important and much publicized scientific expedition to Antarctica. Throughout the course of his explanation, Dyer relates how he led a group of scholars from Miskatonic University on a previous expedition to Antarctica, during which they discovered ancient ruins and a dangerous secret beyond a range of mountains higher than the Himalayas.

            A small advance group, led by Professor Lake, discovers the remains of fourteen prehistoric life-forms previously unknown to science, and also unidentifiable as either plants or animals. Six of the specimens have been badly damaged, while another eight have been preserved in pristine condition. The specimens stratum places them far too early on the geologic time scale for the features of the specimens to have evolved. Some fossils of Cambrian age show signs of the use of tools to carve a specimen for food.
            
            When the main expedition loses contact with Lakes party, Dyer and his colleagues investigate. Lakes camp is devastated, with the majority of men and dogs slaughtered, while a man named Gedney and one of the dogs are absent. Near the expeditions campsite, they find six star-shaped snow mounds with one specimen under each. They also discover that the better preserved life-forms have vanished, and that some form of dissection experiment has been done on both an unnamed man and a dog. The missing man Gedney is suspected of having gone utterly insane and having killed and mutilated all the others.',
            'picture'=> 'logos/YfHIuHonT2n68skUjOW9MX8udSaiLQfib45zBpI1.jpg'
        ]);

        $book2 = Book::create([
            'title' => 'Dagon',
            'author_id' => $author1['id'],
            'description' => 'The story is the testament of a tortured, morphine-addicted man who relates an incident that occurred during his service as an officer during World War I. In the unnamed narrators account, his cargo ship is captured by an Imperial German sea-raider in "one of the most open and least frequented parts of the broad Pacific".[3] He escapes on a lifeboat and drifts aimlessly, south of the equator, until he eventually finds himself stranded on "a slimy expanse of hellish black mire which extended about [him] in monotonous undulations as far as [he] could see.... The region was putrid with the carcasses of decaying fish and less describable things which [he] saw protruding from the nasty mud of the unending plain." He theorizes that this area was formerly a portion of the ocean floor thrown to the surface by volcanic activity, "exposing regions which for innumerable millions of years had lain hidden under unfathomable watery depths."[4]

            After waiting three days for the seafloor to dry out sufficiently to walk on, he ventures out on foot to find the sea and possible rescue. After two days of walking, he reaches his goal, a hill which turns out to be a mound on the edge of an "immeasurable pit or canyon".',
            'picture'=> 'logos/rOJLCPFEutXtay2i58LOuUNVitbfROBkZVxFlAY5.jpg'
        ]);

        $book3 = Book::create([
            'title' => 'The Hobbit',
            'author_id' => $author2['id'],
            'description' => 'Gandalf tricks Bilbo Baggins into hosting a party for Thorin Oakenshield and his band of twelve dwarves (Dwalin, Balin, Kili, Fili, Dori, Nori, Ori, Oin, Gloin, Bifur, Bofur, and Bombur), who sing of reclaiming their ancient home, Lonely Mountain, and its vast treasure from the dragon Smaug. When the music ends, Gandalf unveils Thrórs map showing a secret door into the Mountain and proposes that the dumbfounded Bilbo serve as the expeditions "burglar". The dwarves ridicule the idea, but Bilbo, indignant, joins despite himself.

            The group travels into the wild. Gandalf saves the company from trolls and leads them to Rivendell, where Elrond reveals more secrets from the map. When they attempt to cross the Misty Mountains, they are caught by goblins and driven deep underground. Although Gandalf rescues them, Bilbo gets separated from the others as they flee the goblins. Lost in the goblin tunnels, he stumbles across a mysterious ring and then encounters Gollum, who engages him in a game, each posing a riddle until one of them cannot solve it. If Bilbo wins, Gollum will show him the way out of the tunnels, but if he fails, his life will be forfeit. With the help of the ring, which confers invisibility, Bilbo escapes and rejoins the dwarves, improving his reputation with them. The goblins and Wargs give chase, but the company are saved by eagles. They rest in the house of Beorn.',
            'picture'=> 'logos/SMZe0uVclUBZLthM9SYqmYXMogcsk7fiNpnbweBU.jpg'
        ]);

        $book4 = Book::create([
            'title' => 'The Fellowship of the Ring',
            'author_id' => $author2['id'],
            'description' => 'Bilbo celebrates his eleventy-first (111th) birthday and leaves the Shire suddenly, passing the Ring to Frodo Baggins, his cousin[a] and heir. Neither hobbit is aware of the Rings origin, but the wizard Gandalf suspects it is a Ring of Power. Seventeen years later, Gandalf tells Frodo that he has confirmed that the Ring is the one lost by the Dark Lord Sauron long ago and counsels him to take it away from the Shire. Gandalf leaves, promising to return by Frodos birthday and accompany him on his journey, but fails to do so.

            Frodo sets out on foot, offering a cover story of moving to Crickhollow, accompanied by his gardener Sam Gamgee and his cousin Pippin Took. They are pursued by mysterious Black Riders, but meet a passing group of Elves led by Gildor Inglorion, whose chants to Elbereth ward off the Riders. The hobbits spend the night with them, then take an evasive short cut the next day, and arrive at the farm of Farmer Maggot, who takes them to Bucklebury Ferry, where they meet their friend Merry Brandybuck. When they reach the house at Crickhollow, Merry and Pippin reveal they know about the Ring and insist on travelling with Frodo and Sam.',
            'picture'=> 'logos/eVbjtdZ7M6saIr4ClTLXaHsBH29sqBXPACIGy0eY.jpg'
        ]);

        $copy1 = Copy::create([
            'user_id' => $user1['id'],
            'book_id' => $book4['id'],
            'ISBN' => '1245187549632',
            'publisher' => 'Algoritam',
            'language' => 'English',
            'borrowed' => true
        ]);

        $copy2 = Copy::create([
            'user_id' => $userAdmin['id'],
            'book_id' => $book4['id'],
            'ISBN' => '8574968532456',
            'publisher' => 'Algoritam',
            'language' => 'English',
            'borrowed' => false
        ]);

        $copy3 = Copy::create([
            'user_id' => $userAdmin['id'],
            'book_id' => $book3['id'],
            'ISBN' => '8574123654789',
            'publisher' => 'Nova',
            'language' => 'English',
            'borrowed' => false
        ]);

        $copy4 = Copy::create([
            'user_id' => $userAdmin['id'],
            'book_id' => $book3['id'],
            'ISBN' => '5847123654896',
            'publisher' => 'Nova',
            'language' => 'English',
            'borrowed' => false
        ]);

        $copy5 = Copy::create([
            'user_id' => $userAdmin['id'],
            'book_id' => $book3['id'],
            'ISBN' => '2514963857425',
            'publisher' => 'Inspiration',
            'language' => 'English',
            'borrowed' => false
        ]);

        $copy6 = Copy::create([
            'user_id' => $user1['id'],
            'book_id' => $book2['id'],
            'ISBN' => '2516348795234',
            'publisher' => 'Algoritam',
            'language' => 'English',
            'borrowed' => true
        ]);

        $copy7 = Copy::create([
            'user_id' => $user2['id'],
            'book_id' => $book1['id'],
            'ISBN' => '5241639854721',
            'publisher' => 'NZ',
            'language' => 'English',
            'borrowed' => true
        ]);

        $copy7 = Copy::create([
            'user_id' => $userAdmin['id'],
            'book_id' => $book1['id'],
            'ISBN' => '2514369875214',
            'publisher' => 'NZ',
            'language' => 'English',
            'borrowed' => false
        ]);

        $copy8 = Copy::create([
            'user_id' => $user2['id'],
            'book_id' => $book3['id'],
            'ISBN' => '3625142879654',
            'publisher' => 'TZV Corp',
            'language' => 'English',
            'borrowed' => true
        ]);

        $copy9 = Copy::create([
            'user_id' => $user2['id'],
            'book_id' => $book4['id'],
            'ISBN' => '2514362598745',
            'publisher' => 'TZV Corp',
            'language' => 'English',
            'borrowed' => true
        ]);





    }
}

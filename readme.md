<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

### 首页接口

- 当前日期 ( http://45.157.91.155/NowDate )


    2020年08月10日
- **快速导航** ( http://45.157.91.155/FastNavigation )
    
    
    [
        {
            "id": 1,
            "game": "DOTA2",
            "gameimg": "https:\/\/500bf.com\/static\/index\/img\/dota_sel_icon.png",
            "created_at": null,
            "updated_at": null
        },
        
        {
            "id": 2,
            ...
        },
        
        {
            "id": 3,
            ...
        },
        
        {
            "id": 4,
            "game": "\u738b\u8005\u8363\u8000",
            "gameimg": "https:\/\/500bf.com\/static\/index\/img\/kog_sel_icon.png",
            "created_at": null,
            "updated_at": null
        }
    ]


- 游戏赛事导航 ( http://45.157.91.155/GameNavigation )


    {
        "DOTA2": [
            {
                "id": 270,
                "match": "ESL One\u6cf0\u56fd 2020-\u9884\u9009\u8d5b",
                "matchimg": "https:\/\/qn.feijing88.com\/egame\/dota\/league\/e48ed7e98bad3235b79a2a1648ea60a2.png"
            },
            {
                "id": 269,
                "match": "OMEGA League \u9884\u9009\u8d5b",
                "matchimg": "https:\/\/qn.feijing88.com\/egame\/dota\/league\/547fc21588b1b132a1da55b3c46f693e.png"
            },
            {
                "id": 268,
                "match": "Moon Studio\u4e9a\u6d32\u8054\u8d5b",
                "matchimg": "https:\/\/qn.feijing88.com\/egame\/dota\/league\/9e993fa9bc2034a5ba11cd230700ceeb.png"
            },
            {
                "id": 267,
                "match": "DOTA\u590f\u5b63\u8054\u8d5b \u7b2c\u4e00\u5b63",
                "matchimg": "https:\/\/qn.feijing88.com\/egame\/dota\/league\/a875db9e2bc0bd2e5720d8ae0155ff1c.png"
            }
        ],
        
        "CS:GO": [
           ...
        ],
        
        "\u82f1\u96c4\u8054\u76df": [
            ...
        ],
        
        "\u738b\u8005\u8363\u8000": [
            {
                "id": 250,
                "match": "2020\u738b\u8005\u51a0\u519b\u676f",
                "matchimg": "https:\/\/qn.feijing88.com\/egame\/kog\/league\/9baacc448e77003ed6b32ae66139f630.png"
            },
            {
                "id": 242,
                "match": "2020 \u738b\u8005\u51a0\u519b\u676f",
                "matchimg": "https:\/\/qn.feijing88.com\/egame\/kog\/league\/9baacc448e77003ed6b32ae66139f630.png"
            },
            {
                "id": 193,
                "match": "2020\u4e16\u754c\u51a0\u519b\u676f",
                "matchimg": "https:\/\/qn.feijing88.com\/egame\/kog\/league\/9baacc448e77003ed6b32ae66139f630.png"
            },
            {
                "id": 5,
                "match": "2020 KPL\u6625\u5b63\u8d5b",
                "matchimg": "https:\/\/qn.feijing88.com\/egame\/kog\/league\/3767c1e22299befd683350035b98ad62.png"
            }
        ]
    }

- 首页全部游戏正在进行 ( http://45.157.91.155/GetAllMatchIng )

    
    [
        {
            "id": 1,
            "eventsimg": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/2020612\/f22fd95faa0648aca48e3348fc3ccc60.png",
            "events": "2020 LDL\u590f\u5b63\u8d5b",
            "game": "\u82f1\u96c4\u8054\u76df",
            "eventsid": 139,
            "tv": [
                "\u864e\u7259356",
                "\u6597\u9c7c244",
                "\u6597\u9c7c194",
                "\u864e\u7259821",
                "\u864e\u72592077"
            ],
            "now": "\u7b2c\u4e00\u5c400",
            "BO": "BO3",
            "pooreconomy": "0K",
            "team1img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/202083\/c3feb03d14124449ab7d3e227601c2fc.png",
            "team1": "OMD",
            "team1winnum": 0,
            "team1killnum": 0,
            "team1special": "",
            "team2img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/20190920\/365503c142524f51965a3adb9a2a6c7d.png",
            "team2": "LNG.A",
            "team2winnum": 0,
            "team2killnum": 0,
            "team2special": "",
            "created_at": null,
            "updated_at": null
        },
        ... . ..
        {
            "id": 7,
            "eventsimg": "https:\/\/qn.feijing88.com\/egame\/csgo\/league\/6cb32166930104d7c043ca5f470ce21a.png",
            "events": "Nine to Five 3 Dawn",
            "game": "CS:GO",
            "eventsid": 293,
            "tv": "",
            "now": "MIRAGER:26",
            "BO": "BO3",
            "pooreconomy": "0K",
            "team1img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/csgo\/team.png",
            "team1": "Tikitakan",
            "team1winnum": 0,
            "team1killnum": 0,
            "team1special": "https:\/\/www.500bf.com\/static\/index\/img\/cs_firstkill.png|https:\/\/www.500bf.com\/static\/index\/img\/cs_mine.png|https:\/\/www.500bf.com\/static\/index\/img\/cs_16kill.png",
            "team2img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/20190121\/9dab47b972af4930bcfc87e3c62ef507.jpg",
            "team2": "Nexus",
            "team2winnum": 1,
            "team2killnum": 0,
            "team2special": "",
            "created_at": null,
            "updated_at": null
        }
    ]


- 首页指定游戏正在进行 ( http://45.157.91.155/AppointMatchIng/$id ) 


    [
        {
            "id": 1,
            "eventsimg": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/2020612\/f22fd95faa0648aca48e3348fc3ccc60.png",
            "events": "2020 LDL\u590f\u5b63\u8d5b",
            "game": "\u82f1\u96c4\u8054\u76df",
            "eventsid": 139,
            "tv": [
                "\u864e\u7259356",
                "\u6597\u9c7c244",
                "\u6597\u9c7c194",
                "\u864e\u7259821",
                "\u864e\u72592077"
            ],
            "now": "\u7b2c\u4e00\u5c400",
            "BO": "BO3",
            "pooreconomy": "0K",
            "team1img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/202083\/c3feb03d14124449ab7d3e227601c2fc.png",
            "team1": "OMD",
            "team1winnum": 0,
            "team1killnum": 0,
            "team1special": "",
            "team2img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/20190920\/365503c142524f51965a3adb9a2a6c7d.png",
            "team2": "LNG.A",
            "team2winnum": 0,
            "team2killnum": 0,
            "team2special": "",
            "created_at": null,
            "updated_at": null
        },
        ... ...
        {
            "id": 5,
            "eventsimg": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/2020612\/f22fd95faa0648aca48e3348fc3ccc60.png",
            "events": "2020 LDL\u590f\u5b63\u8d5b",
            "game": "\u82f1\u96c4\u8054\u76df",
            "eventsid": 139,
            "tv": [
                "\u864e\u7259356",
                "\u6597\u9c7c194",
                "\u864e\u72592077",
                "\u864e\u7259899"
            ],
            "now": "\u7b2c\u4e00\u5c400",
            "BO": "BO3",
            "pooreconomy": "0K",
            "team1img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/20190920\/4a5cd1199d504544abe9513ae2c32493.png",
            "team1": "VTG",
            "team1winnum": 0,
            "team1killnum": 0,
            "team1special": "",
            "team2img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/20190302\/af20d3e7409b499aa1216eaabcf0ab6c.jpg",
            "team2": "LEG",
            "team2winnum": 0,
            "team2killnum": 0,
            "team2special": "",
            "created_at": null,
            "updated_at": null
        }
    ]


- 首页全部游戏未开始 ( http://45.157.91.155/GetAllMatch )


    [
        {
            "id": 1,
            "gameimg": "https:\/\/www.500bf.com\/static\/index\/img\/lol_sel_icon.png",
            "game": "\u82f1\u96c4\u8054\u76df",
            "time": "16:00",
            "BO": "BO3",
            "team1": "OZ",
            "team1img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/lol\/team.png",
            "team2img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/lol\/team.png",
            "team2": "ELM",
            "eventsimg": "https:\/\/qn.feijing88.com\/egame\/lol\/league\/9c7ea58bd9ffe8e5a1602dd166a2a0cc.jpg",
            "events": "2020 CK\u590f\u5b63\u8d5b",
            "eventsid": 175,
            "created_at": null,
            "updated_at": null
        },
        ...
        {
            "id": 20,
            "gameimg": "https:\/\/www.500bf.com\/static\/index\/img\/csgo_sel_icon.png",
            "game": "CS:GO",
            "time": "16:30",
            "BO": "BO3",
            "team1": "Ground Zero",
            "team1img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/20190121\/584f7d5686124b9285f1f90f061ee1bb.jpg",
            "team2img": "https:\/\/qn.feijing88.com\/egame\/csgo\/team\/35dbd4e5a101fff12c3368615ff040fd.png",
            "team2": "Paradox",
            "eventsimg": "https:\/\/qn.feijing88.com\/egame\/csgo\/league\/9dea94311125f453bdf2855766440667.png",
            "events": "ESL Australia & NZ Championship Season 11",
            "eventsid": 110,
            "created_at": null,
            "updated_at": null
        }
    ]


- 首页指定游戏未开始 ( http://45.157.91.155/AppointMatch/$id )


    [
        {
            "id": 4,
            "gameimg": "https:\/\/www.500bf.com\/static\/index\/img\/csgo_sel_icon.png",
            "game": "CS:GO",
            "time": "17:10",
            "BO": "BO3",
            "team1": "AVANT",
            "team1img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/20190121\/48b9b58ae0814a97844a62d981bda9f1.jpg",
            "team2img": "https:\/\/qn.feijing88.com\/egame\/csgo\/team\/35dbd4e5a101fff12c3368615ff040fd.png",
            "team2": "Paradox",
            "eventsimg": "https:\/\/qn.feijing88.com\/egame\/csgo\/league\/038803234a89e88bdcf7388fc19eb0cd.png",
            "events": "ESEA MDL Season 34 Australia",
            "eventsid": 55,
            "created_at": null,
            "updated_at": null
        },
        ... ...
        {
            "id": 20,
            "gameimg": "https:\/\/www.500bf.com\/static\/index\/img\/csgo_sel_icon.png",
            "game": "CS:GO",
            "time": "16:30",
            "BO": "BO3",
            "team1": "Ground Zero",
            "team1img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/20190121\/584f7d5686124b9285f1f90f061ee1bb.jpg",
            "team2img": "https:\/\/qn.feijing88.com\/egame\/csgo\/team\/35dbd4e5a101fff12c3368615ff040fd.png",
            "team2": "Paradox",
            "eventsimg": "https:\/\/qn.feijing88.com\/egame\/csgo\/league\/9dea94311125f453bdf2855766440667.png",
            "events": "ESL Australia & NZ Championship Season 11",
            "eventsid": 110,
            "created_at": null,
            "updated_at": null
        }
    ]


- 首页右侧刚刚结束 ( http://45.157.91.155/JustOver )


    [
        {
            "gameimg": "https:\/\/www.500bf.com\/static\/index\/img\/lol_sel_icon.png",
            "team1": "CLG",
            "score": "0-2",
            "team2": "DIG",
            "time": "08:03"
        },
        ... ...
        {
            "gameimg": "https:\/\/www.500bf.com\/static\/index\/img\/csgo_sel_icon.png",
            "team1": "Chaos",
            "score": "0-2",
            "team2": "New England Whalers",
            "time": "04:55"
        }
    ]



### 比分页接口

- 全部游戏未开始 ( http://45.157.91.155/ScoreNotStarted )


    [
        {
            "id": 1,
            "gameimg": "https:\/\/www.500bf.com\/static\/index\/img\/lol_sel_icon.png",
            "game": "\u82f1\u96c4\u8054\u76df",
            "time": "16:00",
            "BO": "BO3",
            "team1": "OZ",
            "team1img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/lol\/team.png",
            "team2img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/lol\/team.png",
            "team2": "ELM",
            "eventsimg": "https:\/\/qn.feijing88.com\/egame\/lol\/league\/9c7ea58bd9ffe8e5a1602dd166a2a0cc.jpg",
            "events": "2020 CK\u590f\u5b63\u8d5b",
            "eventsid": 175,
            "index": "",
            "created_at": null,
            "updated_at": null
        },
         ... ...
        {
            "id": 19,
            "gameimg": "https:\/\/www.500bf.com\/static\/index\/img\/csgo_sel_icon.png",
            "game": "CS:GO",
            "time": "15:00",
            "BO": "BO3",
            "team1": "Tikitakan",
            "team1img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/csgo\/team.png",
            "team2img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/20190121\/9dab47b972af4930bcfc87e3c62ef507.jpg",
            "team2": "Nexus",
            "eventsimg": "https:\/\/qn.feijing88.com\/egame\/csgo\/league\/6cb32166930104d7c043ca5f470ce21a.png",
            "events": "Nine to Five 3 Dawn",
            "eventsid": 293,
            "index": "1.45\/2.63",
            "created_at": null,
            "updated_at": null
        }
    ]

- 指定获取游戏未开始 ( http://45.157.91.155/ScoreAppointNotStarted/{id} ) 


    [
        {
            "id": 4,
            "gameimg": "https:\/\/www.500bf.com\/static\/index\/img\/csgo_sel_icon.png",
            "game": "CS:GO",
            "time": "17:10",
            "BO": "BO3",
            "team1": "AVANT",
            "team1img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/20190121\/48b9b58ae0814a97844a62d981bda9f1.jpg",
            "team2img": "https:\/\/qn.feijing88.com\/egame\/csgo\/team\/35dbd4e5a101fff12c3368615ff040fd.png",
            "team2": "Paradox",
            "eventsimg": "https:\/\/qn.feijing88.com\/egame\/csgo\/league\/038803234a89e88bdcf7388fc19eb0cd.png",
            "events": "ESEA MDL Season 34 Australia",
            "eventsid": 55,
            "index": "1.25\/3.7",
            "created_at": null,
            "updated_at": null
        },
        ... ...
        {
            "id": 19,
            "gameimg": "https:\/\/www.500bf.com\/static\/index\/img\/csgo_sel_icon.png",
            "game": "CS:GO",
            "time": "15:00",
            "BO": "BO3",
            "team1": "Tikitakan",
            "team1img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/csgo\/team.png",
            "team2img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/20190121\/9dab47b972af4930bcfc87e3c62ef507.jpg",
            "team2": "Nexus",
            "eventsimg": "https:\/\/qn.feijing88.com\/egame\/csgo\/league\/6cb32166930104d7c043ca5f470ce21a.png",
            "events": "Nine to Five 3 Dawn",
            "eventsid": 293,
            "index": "1.45\/2.63",
            "created_at": null,
            "updated_at": null
        }
    ]

- 全部游戏完场 ( http://45.157.91.155/GetScoreOver )


    [
        {
            "id": 1,
            "gameimg": "https:\/\/www.500bf.com\/static\/index\/img\/lol_sel_icon.png",
            "game": "\u82f1\u96c4\u8054\u76df",
            "time": "00:09",
            "BO": "BO5",
            "team1": "Team Quesco",
            "team1img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/2020121\/765de0df0352448aa620c5822c130bd0.png",
            "score": "1-3",
            "team2img": "https:\/\/qn.feijing88.com\/egame\/lol\/team\/f1c9d625b6c6803231ac1e367110edff.png",
            "team2": "CRB",
            "eventsimg": "\/static\/index\/img\/lol_sel_icon.png",
            "events": "2020 LVP SLO\u590f\u5b63\u8d5b",
            "eventsid": 168,
            "index": "4.938\/1.161",
            "created_at": null,
            "updated_at": null
        },
        ... ...
        {
            "id": 14,
            "gameimg": "https:\/\/www.500bf.com\/static\/index\/img\/csgo_sel_icon.png",
            "game": "CS:GO",
            "time": "11:35",
            "BO": "BO1",
            "team1": "Eclipse",
            "team1img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/csgo\/team.png",
            "score": "14-16",
            "team2img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/csgo\/team.png",
            "team2": "Northern Forces",
            "eventsimg": "\/static\/index\/img\/csgo_sel_icon.png",
            "events": "IEM New York 2020 North America Open Qualifier 1",
            "eventsid": 300,
            "index": "-\/-",
            "created_at": null,
            "updated_at": null
        }
    ]

- 指定获取游戏完场 ( http://45.157.91.155/ScoreAppointOver/$id )


    [
        {
            "id": 3,
            "gameimg": "https:\/\/www.500bf.com\/static\/index\/img\/csgo_sel_icon.png",
            "game": "CS:GO",
            "time": "01:50",
            "BO": "BO3",
            "team1": "Yeah",
            "team1img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/202065\/0a576787ee42444ea7167097d3bd1cfa.webp",
            "score": "0-2",
            "team2img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/20190121\/649231a18f554ab2aa8ec9c50d05e410.jpg",
            "team2": "Cloud9",
            "eventsimg": "\/static\/index\/img\/csgo_sel_icon.png",
            "events": "DreamHack Open Summer 2020 North America",
            "eventsid": 287,
            "index": "4.18\/1.2",
            "created_at": null,
            "updated_at": null
        },
        ... ...
        {
            "id": 14,
            "gameimg": "https:\/\/www.500bf.com\/static\/index\/img\/csgo_sel_icon.png",
            "game": "CS:GO",
            "time": "11:35",
            "BO": "BO1",
            "team1": "Eclipse",
            "team1img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/csgo\/team.png",
            "score": "14-16",
            "team2img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/csgo\/team.png",
            "team2": "Northern Forces",
            "eventsimg": "\/static\/index\/img\/csgo_sel_icon.png",
            "events": "IEM New York 2020 North America Open Qualifier 1",
            "eventsid": 300,
            "index": "-\/-",
            "created_at": null,
            "updated_at": null
        }
    ]

### 赛程页面

- 获取当前星期的日期 ( http://45.157.91.155/GetWeek )
    
    
    [
        {
            "date": "08月10日",
            "date2": "2020-08-10",
            "week": "星期一"
        },
        ... ...
        {
            "date": "08月16日",
            "date2": "2020-08-16",
            "week": "星期日"
        }
    ]

- 根据时间获取全部游戏 ( http://45.157.91.155/CourseAll/$date )


    例： http://45.157.91.155/CourseAll/2020-08-19
    [
        {
            "id": 6481,
            "gameimg": "https:\/\/www.500bf.com\/static\/index\/img\/csgo_sel_icon.png",
            "gametype": "CS:GO",
            "matchtime": "2020-08-19 00:30",
            "BO": "BO3",
            "team1": "fnatic",
            "team1img": "https:\/\/qn.feijing88.com\/egame\/csgo\/team\/bfbc68a63f191780e16012047b9371bf.svg",
            "score": "-",
            "team2img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/20191113\/ce2d725cd4e042cda94e25a667b8a211.svg",
            "team2": "Astralis",
            "eventsimg": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/20190930\/8862ad16343245999942776f25ec5ce7.jpg",
            "events": "ESL One Cologne 2020 Europe",
            "eventsid": 295,
            "created_at": null,
            "updated_at": null
        },
        ... ...
        {
            "id": 6486,
            "gameimg": "https:\/\/www.500bf.com\/static\/index\/img\/csgo_sel_icon.png",
            "gametype": "CS:GO",
            "matchtime": "2020-08-19 21:00",
            "BO": "BO3",
            "team1": "Complexity",
            "team1img": "https:\/\/qn.feijing88.com\/egame\/csgo\/team\/a39c8c7dc65b3962b35de6877f3a9260.svg",
            "score": "-",
            "team2img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/20190615\/80858015697c4f4caec11b0cf5e2a7f1.jpg",
            "team2": "MAD Lions",
            "eventsimg": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/20190930\/8862ad16343245999942776f25ec5ce7.jpg",
            "events": "ESL One Cologne 2020 Europe",
            "eventsid": 295,
            "created_at": null,
            "updated_at": null
        }
    ]

- 根据时间获取指定游戏 ( http://45.157.91.155/CourseAppoint/$date/$id )

    
    例：http://127.0.0.1:8000/CourseAppoint/2020-08-26/2
    [
        {
            "id": 6493,
            "gameimg": "https:\/\/www.500bf.com\/static\/index\/img\/csgo_sel_icon.png",
            "gametype": "CS:GO",
            "matchtime": "2020-08-26 14:00",
            "BO": "BO3",
            "team1": "ORDER",
            "team1img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/20190121\/55e8578a0ccf43dc98329eb48364d4df.jpg",
            "score": "-",
            "team2img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/20190121\/48b9b58ae0814a97844a62d981bda9f1.jpg",
            "team2": "AVANT",
            "eventsimg": "https:\/\/qn.feijing88.com\/egame\/csgo\/league\/8c92150df45c7aca335542058eebc03d.png",
            "events": "ESL One Cologne 2020 Oceania",
            "eventsid": 297,
            "created_at": null,
            "updated_at": null
        },
        {
            "id": 6494,
            "gameimg": "https:\/\/www.500bf.com\/static\/index\/img\/csgo_sel_icon.png",
            "gametype": "CS:GO",
            "matchtime": "2020-08-26 17:30",
            "BO": "BO3",
            "team1": "ViCi",
            "team1img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/20190121\/0ef4e915c3d7489ca264d1e312d8f110.jpg",
            "score": "-",
            "team2img": "https:\/\/qn.feijing88.com\/egame\/csgo\/team\/8c02728d7bbf685212badc8691557a57.png",
            "team2": "Invictus",
            "eventsimg": "https:\/\/qn.feijing88.com\/egame\/csgo\/league\/d9d1bdc0940952bf4474c3b25cabceb9.png",
            "events": "ESL One Cologne 2020 Asia",
            "eventsid": 298,
            "created_at": null,
            "updated_at": null
        }
    ]


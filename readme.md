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

- 全部游戏正在进行 ( http://45.157.91.155/GetScoreIng )


    [
        {
            "id": 1,
            "gameimg": "https:\/\/www.500bf.com\/static\/index\/img\/csgo_sel_icon.png",
            "game": "CS:GO",
            "events": "Nine to Five 3 Dawn",
            "eventsid": "293",
            "tag": "BO3",
            "tag1": "\u9635\u5bb9",
            "tag2": "\u672c\u5c40 ",
            "tag3": "\u4e0a\u534a\u573a ",
            "tag4": "\u4e0b\u534a\u573a ",
            "tag5": "\u52a0\u65f6 ",
            "tag6": "",
            "index": "\u6307\u6570",
            "tv": [
                "\u864e\u7259356",
                "\u6597\u9c7c244",
                "\u6597\u9c7c194",
                "\u864e\u7259821",
                "\u864e\u72592077"
            ],
            "now": "",
            "nowtime": "R:",
            "team1img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/csgo\/team.png",
            "team1": "Tenerife Titans",
            "team1winnum": 1,
            "team1lineup": "T",
            "team1killnum": 8,
            "team1killspecial": [
                "https:\/\/www.500bf.com\/static\/index\/img\/cs_firstkill.png",
                "https:\/\/www.500bf.com\/static\/index\/img\/cs_mine.png"
            ],
            "team1tag3num": "8",
            "team1tag3special": [
                "https:\/\/www.500bf.com\/static\/index\/img\/cs_firstkill.png",
                "https:\/\/www.500bf.com\/static\/index\/img\/cs_mine.png"
            ],
            "team1tag4num": "0",
            "team1tag4special": [
                "https:\/\/www.500bf.com\/static\/index\/img\/cs_firstkill.png",
                "https:\/\/www.500bf.com\/static\/index\/img\/cs_mine.png"
            ],
            "team1tag5num": "0",
            "team1tag5special": [
                "https:\/\/www.500bf.com\/static\/index\/img\/cs_firstkill.png",
                "https:\/\/www.500bf.com\/static\/index\/img\/cs_mine.png"
            ],
            "team1tag6num": "1.11K",
            "team1indexnum": "2.73",
            "team2img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/20190404\/8e65baff92994083a977840de410e65c.jpg",
            "team2": "Apeks",
            "team2winnum": 0,
            "team2lineup": "CT",
            "team2killnum": 10,
            "team2killspecial": [
                "https:\/\/www.500bf.com\/static\/index\/img\/cs_firstkill.png",
                "https:\/\/www.500bf.com\/static\/index\/img\/cs_mine.png"
            ],
            "team2tag3num": "7",
            "team2tag3special": [
                "https:\/\/www.500bf.com\/static\/index\/img\/cs_firstkill.png",
                "https:\/\/www.500bf.com\/static\/index\/img\/cs_mine.png"
            ],
            "team2tag4num": "3",
            "team2tag4special": [
                "https:\/\/www.500bf.com\/static\/index\/img\/cs_firstkill.png",
                "https:\/\/www.500bf.com\/static\/index\/img\/cs_mine.png"
            ],
            "team2tag5num": "0",
            "team2tag5special": [
                "https:\/\/www.500bf.com\/static\/index\/img\/cs_firstkill.png",
                "https:\/\/www.500bf.com\/static\/index\/img\/cs_mine.png"
            ],
            "team2tag6num": "",
            "team2indexnum": "1.42",
            "created_at": null,
            "updated_at": null,
            "pooimg": "http:\/\/qn.gunqiu.com\/pcweb\/drop_icon.png"
        },
         ... ...
        {
            "id": 6,
            "gameimg": "https:\/\/www.500bf.com\/static\/index\/img\/csgo_sel_icon.png",
            "game": "CS:GO",
            "events": "ESL Australia & NZ Championship Season 11",
            "eventsid": "110",
            "tag": "BO3",
            "tag1": "\u9635\u5bb9",
            "tag2": "\u672c\u5c40 ",
            "tag3": "\u4e0a\u534a\u573a ",
            "tag4": "\u4e0b\u534a\u573a ",
            "tag5": "\u52a0\u65f6 ",
            "tag6": "",
            "index": "\u6307\u6570",
            "tv": "",
            "now": "",
            "nowtime": "R:",
            "team1img": "https:\/\/qn.feijing88.com\/egame\/csgo\/team\/35dbd4e5a101fff12c3368615ff040fd.png",
            "team1": "Paradox",
            "team1winnum": 0,
            "team1lineup": "T",
            "team1killnum": 1,
            "team1killspecial": "",
            "team1tag3num": "1",
            "team1tag3special": "",
            "team1tag4num": "0",
            "team1tag4special": "",
            "team1tag5num": "0",
            "team1tag5special": "",
            "team1tag6num": "",
            "team1indexnum": "1.38",
            "team2img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/csgo\/team.png",
            "team2": "TRUCKERS WITH ATTITUDE",
            "team2winnum": 0,
            "team2lineup": "CT",
            "team2killnum": 0,
            "team2killspecial": "",
            "team2tag3num": "0",
            "team2tag3special": "",
            "team2tag4num": "0",
            "team2tag4special": "",
            "team2tag5num": "0",
            "team2tag5special": "",
            "team2tag6num": "",
            "team2indexnum": "2.94",
            "created_at": null,
            "updated_at": null,
            "pooimg": ""
        }
    ]


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

### 直播页面

- http://45.157.91.155/Video/$id
    
    
    
    
    {
        "eventsimg": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/2020612\/f22fd95faa0648aca48e3348fc3ccc60.png",
        "events": "2020 LDL\u590f\u5b63\u8d5b",
        "BO": "BO3",
        "tv": {
            "\u864e\u7259356": "https:\/\/esportsapi.feijing88.com\/live\/v2\/?v=b59260462057d8cac878d00fd60649d3a05eb67129ddc655d0937953d975f8b6fb828cb0fa9e9b509d85157f1fd1993977ca1ce1aeafafc4c598633acf2c9a00c48fafaa8f957987b45df7d36484fbe5",
            "\u6597\u9c7c244": "https:\/\/www.500bf.com\/index\/index\/living\/match_id\/268076636\/idx\/1.html",
            "\u6597\u9c7c194": "https:\/\/esportsapi.feijing88.com\/live\/v2\/?v=6a7446ebd0a9f89d3035ada4ca84edf102d62812364a057cd5c0b1670c9e45cda56efe69c884c145025fb0a7ee5888b4f6915c5e25d2485448c3659fbb9073d7",
            "\u864e\u7259821": "https:\/\/esportsapi.feijing88.com\/live\/v2\/?v=fb15acc87d797891163255e2748ac49b3c6da1fbaa89ff04e88b624fd7d46e1ffb828cb0fa9e9b509d85157f1fd1993977ca1ce1aeafafc4c598633acf2c9a0055d53445e0d0fafd98edde00faea89c7",
            "\u864e\u72592077": "https:\/\/esportsapi.feijing88.com\/live\/v2\/?v=f2dcce8ef756cdd913583bc3a8edc643991a6a350ed32e96eb46208803058c14fb828cb0fa9e9b509d85157f1fd1993977ca1ce1aeafafc4c598633acf2c9a003de7089fe68971030e851acfd0fd79f2"
        },
        "team1": "OMD",
        "team1img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/202083\/c3feb03d14124449ab7d3e227601c2fc.png",
        "team1winnum": 0,
        "team2winnum": 0,
        "team2img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/20190920\/365503c142524f51965a3adb9a2a6c7d.png",
        "team2": "LNG.A",
        "time": "08\u670810\u65e5 13:00"
    }

### 赛事页面

- 根据ID获取赛事所有比赛 ( http://45.157.91.155/Match/$id )


    http://45.157.91.155/Match/33
    
    [
        {
            "id": 532,
            "event": "Home Camp",
            "eventid": "33",
            "time": "04-24\u00a021:00",
            "team1img": "https:\/\/qn.feijing88.com\/egame\/dota\/team\/baf4b7e3d5a245068eb6d8071a307b42.png",
            "team1": "Cyber TRAKTOR",
            "score": "0-0",
            "team2img": "https:\/\/qn.feijing88.com\/egame\/dota\/team\/d53a81ded73b42ef96e9a2ed6c90e507.png",
            "team2": "NOVA",
            "BO": "BO2",
            "created_at": null,
            "updated_at": null
        },
        ... ...
        {
            "id": 557,
            "event": "Home Camp",
            "eventid": "33",
            "time": "05-05\u00a001:45",
            "team1img": "https:\/\/qn.feijing88.com\/egame\/dota\/team\/d53a81ded73b42ef96e9a2ed6c90e507.png",
            "team1": "NOVA",
            "score": "3-0",
            "team2img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/20181126\/d4bf8b386e5747dcb20070f4cb35283f.jpg",
            "team2": "friends",
            "BO": "BO5",
            "created_at": null,
            "updated_at": null
        }
    ]


### 资讯页面

- 右边栏正在进行比赛 ( http://45.157.91.155/SidebarIng )


    [
        {
            "game": "https:\/\/500bf.com\/static\/index\/img\/lol_sel_icon.png",
            "team1": "OMD",
            "team1winnum": 0,
            "team2winnum": 0,
            "team2": "LNG.A",
            "events": "2020 LDL\u590f\u5b63\u8d5b",
            "time": "13:00"
        },
        ... ...
        {
            "game": "https:\/\/500bf.com\/static\/index\/img\/lol_sel_icon.png",
            "team1": "87",
            "team1winnum": 0,
            "team2winnum": 0,
            "team2": "WE.A",
            "events": "2020 LDL\u590f\u5b63\u8d5b",
            "time": "15:00"
        }
    ]

- 右边栏即将开始比赛 ( http://45.157.91.155/SidebarSonn )


    [
        {
            "gameimg": "https:\/\/www.500bf.com\/static\/index\/img\/lol_sel_icon.png",
            "team1": "OZ",
            "team2": "ELM",
            "time": "16:00"
        },
        ... ...
        {
            "gameimg": "https:\/\/www.500bf.com\/static\/index\/img\/csgo_sel_icon.png",
            "team1": "",
            "team2": "",
            "time": "21:00"
        }
    ]


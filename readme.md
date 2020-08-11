<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

### 首页接口

- 当前日期 ( http://127.0.0.1:8000/NowDate )


    2020年08月10日
- **快速导航** ( http://127.0.0.1:8000/FastNavigation )
    
    
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


- 游戏赛事导航 ( http://127.0.0.1:8000/GameNavigation )


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

- 首页全部游戏未开始 ( http://127.0.0.1:8000/GetAllMatch )


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


- 首页指定游戏未开始 ( http://127.0.0.1:8000/AppointMatch/$id )


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


- 首页右侧刚刚结束 ( http://127.0.0.1:8000/JustOver )


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

- 全部游戏未开始 ( http://127.0.0.1:8000/ScoreNotStarted )


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


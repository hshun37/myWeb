const quotes = [
    {
      quote: "어떤 사람들은 3루에 태어났지만 자신이 3루타를 쳤다고 생각하면서 인생을 산다.",
      author: "베리 스윗처",
    },
    {
      quote: "우리는 나이가 들면서 변하는 게 아니다. 보다 자기다워지는 것이다.",
      author: "린 홀",
    },
    {
      quote: "성숙하다는 것은 다가오는 모든 생생한 위기를 피하지 않고 마주하는 것을 의미한다.",
      author: "프리츠 쿤켈",
    },
    {
      quote: "우리는 항상 젊음을 위해 미래를 개발할 수는 없지만, 미래를 위해 우리의 젊음을 개발할 수는 있다.",
      author: "프랭클린 D. 루스벨트",
    },
    {
      quote: "출생과 죽음은 피할 수 없으므로 그 사이를 즐겨라.",
      author: "조지 산타야나",
    },
    {
      quote: "인생의 최대 역설은 살아서 빠져나오는 사람이 거의 없다는 점이다.",
      author: "로버트 하인라인",
    },
    {
      quote: "인생은 자전거를 타는 것과 같다. 균형을 잡으려면 움직여야 한다.",
      author: "알버트 아인슈타인",
    },
    {
      quote: "모두가 오래 살고 싶어 하지만 아무도 늙고 싶어 하지는 않는다.",
      author: "벤자민 프랭클린",
    },
    {
      quote: "올바른 순간에 잘못된 행동을 하는 것이 삶의 모순 중 하나라고 생각한다.",
      author: "찰리 채플린",
    },
    {
      quote: "노인이 젊은이에게 얘기하듯이 망자도 산자에게 이야기하려고 노력한다면 좋을텐데.",
      author: "윌라 카서",
    },
  ];
  
  const quote = document.querySelector("#quote span:first-child");
  const author = document.querySelector("#quote span:last-child");

  const todaysQuote = quotes[Math.floor(Math.random() * quotes.length)];

    quote.innerText = todaysQuote.quote;
    author.innerText = todaysQuote.author;
